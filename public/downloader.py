from time import sleep

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from pathlib import Path
from Levenshtein import distance as lev
import random
from datetime import datetime
import mysql.connector


class MySqlWwrapper:
    config = {
        'user': 'sail',
        'password': 'password',
        'host': '127.0.0.1',
        'database': 'politics',
        'raise_on_warnings': True
    }

    def __init__(self, config=None):
        if config is None:
            config = self.config
        self.cnx = mysql.connector.connect(**config)
        self.get_names()

    def get_names(self):
        mycursor = self.cnx.cursor()
        mycursor.execute(f'SELECT nick FROM politicians')
        myresult = mycursor.fetchall()
        names = []
        for x in myresult:
            names.append(x[0].replace('.', '_'))
        return names

    def save_timestamp(self):
        mycursor = self.cnx.cursor()

        mycursor.execute('SELECT count(*) as total FROM last_updates')
        count = mycursor.fetchone()

        if count[0] == 0:
            mycursor.execute('INSERT INTO last_updates (created_at) VALUES (DEFAULT)')
            self.cnx.commit()
        else:
            mycursor.execute('UPDATE last_updates SET created_at = DEFAULT LIMIT 1')
            self.cnx.commit()
        print(mycursor.rowcount, "record inserted into update.")

    def check_and_create_tables(self):
        names = self.get_names()
        mycursor = self.cnx.cursor()
        mycursor.execute("SHOW TABLES")
        tables = []
        for table in mycursor:
            tables.append(table[0])
        if "last_updates" not in tables:
            mycursor.execute(
                f'CREATE TABLE last_updates (id INT AUTO_INCREMENT PRIMARY KEY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)')
            print(f'Table last_updates created')
        for name in names:
            if name not in tables:
                mycursor.execute(
                    f'CREATE TABLE {name} (id INT AUTO_INCREMENT PRIMARY KEY, text TEXT, date DATETIME DEFAULT CURRENT_TIMESTAMP, edit BOOLEAN, img TEXT)')
                print(f'Table {name} created')
        return names

    def insert_text(self, name, text, edit, img):
        if "Zobrazit víc" in text:
            print("0 record inserted.")
            return
        mycursor = self.cnx.cursor()

        sql = f'INSERT INTO {name} (text, edit, img) VALUES (%s, %s, %s)'
        # val = (text, datetime.now().strftime('%Y-%m-%d %H:%M:%S'))
        mycursor.execute(sql, [text, edit, img])

        self.cnx.commit()
        print(mycursor.rowcount, "record inserted.")

    def get_last_saved_messsage(self, name):
        mycursor = self.cnx.cursor()

        mycursor.execute(f'SELECT text FROM {name} ORDER BY date DESC LIMIT 1')

        myresult = mycursor.fetchone()

        print(myresult)
        return "" if myresult is None else myresult[0]

    def update(self, name, img):
        mycursor = self.cnx.cursor()

        sql = f'UPDATE {name} SET img = %s ORDER BY date DESC LIMIT 1'
        # val = (text, datetime.now().strftime('%Y-%m-%d %H:%M:%S'))
        mycursor.execute(sql, [img])

        self.cnx.commit()
        print(mycursor.rowcount, "record updated.")


class Credentials:
    def __init__(self, email, password):
        self.email = email
        self.password = password


class Downloader:
    driverLocation = '/usr/local/bin/chromedriver'
    user_agent_list = [
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:77.0) Gecko/20100101 Firefox/77.0',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
    ]
    fb_url = 'https://cs-cz.facebook.com/'
    path = '/Users/i343623/PycharmProjects/'

    def __init__(self):
        self.__init_driver__()
        self.db = MySqlWwrapper()
        self.names = self.db.check_and_create_tables()
        names = [name.replace('_', '.') for name in self.names]

        self.urls = [self.fb_url + name for name in names]
        # self.message_files = [Path(self.path + name + '.last') for name in names]
        # self.debug_files = [Path(self.path + name + '.debug') for name in names]

    def __init_driver__(self):
        options = Options()
        options.headless = True
        # options.add_argument('--disable-gpu')
        options.add_argument('--no-sandbox')
        # options.add_argument("--example-flag")
        options.add_argument('--disable-dev-shm-usage')
        options.add_argument('--window-size=1420,1080')
        prefs = {"profile.default_content_setting_values.notifications": 2}
        options.add_experimental_option("prefs", prefs)
        options.add_argument(f'user-agent={random.choice(self.user_agent_list)}')
        self.driver = webdriver.Chrome(executable_path=self.driverLocation, options=options)

    def accept_cookies(self):
        try:
            WebDriverWait(self.driver, 2).until(
                EC.presence_of_element_located((By.XPATH, "//*[contains(text(), 'Povolit všechny soubory cookie')]"))
            )
            button = self.driver.find_element_by_xpath("//*[contains(text(), 'Povolit všechny soubory cookie')]")
            button.click()
        except:
            pass
        # WebDriverWait(driver, 2).until(
        #     EC.presence_of_element_located((By.XPATH, "//*[contains(text(), 'Přijmout vše')]"))
        # )
        # button = driver.find_element_by_xpath("//*[contains(text(), 'Přijmout vše')]")
        # button.click()

    def login(self):
        email = self.driver.find_element_by_name("email")
        email.send_keys(self.credentials.email)
        sleep(1)

        password = self.driver.find_element_by_name("pass")
        password.send_keys(self.credentials.password)
        sleep(1)

        # login = driver.find_element_by_css_selector('[aria-label="Accessible login button"]')
        login = self.driver.find_element_by_name('login')
        login.click()
        sleep(1)

    def get_last_message(self):
        try:
            WebDriverWait(self.driver, 5).until(
                EC.presence_of_element_located((By.XPATH, "//*[contains(text(),'Zobrazit víc')]"))
            )
            see_more = self.driver.find_element_by_xpath("//*[contains(text(),'Zobrazit víc')]")  # 'Zobrazit víc')]")
            # self.driver.save_screenshot('/Users/i343623/PycharmProjects/blaha/message2.png')
            self.driver.execute_script("arguments[0].scrollIntoView();", see_more)

            try:
                WebDriverWait(self.driver, 2).until(
                    EC.presence_of_element_located((By.CSS_SELECTOR, "[aria-label=Zavřít]"))
                )
                self.driver.find_element_by_css_selector("[aria-label=Zavřít]").click()
                WebDriverWait(self.driver, 2).until_not(
                    EC.presence_of_element_located((By.CSS_SELECTOR, "[aria-label=Zavřít]"))
                )
            except:
                pass
            self.driver.execute_script("arguments[0].click();", see_more)

        except:
            pass

        # WebDriverWait(driver, 10).until(
        #     EC.presence_of_element_located((By.XPATH, "//*[contains(text(), 'Zobrazit víc']")) #'Zobrazit víc')]"))
        # )

        return self.driver.find_element_by_css_selector("[data-ad-comet-preview=message]")

    def check_messages_difference(self, name):
        last_message = self.db.get_last_saved_messsage(name)
        message = self.get_last_message()
        return lev(last_message, message.text), message

    def get_image_if_exist(self, message):
        try:
            div = message.find_element_by_xpath('..')
            img = div.find_element_by_xpath('following-sibling::div').find_element_by_tag_name("img")

            return img.get_attribute('src')
        except Exception as e:
            return None

    def get_messages(self):
        try:
            for i in range(len(self.names)):
                try:
                    self.driver.get(self.urls[i])
                    self.accept_cookies()

                    distance, message = self.check_messages_difference(self.names[i])
                    img = self.get_image_if_exist(message)
                    edit = False
                    if distance == 0:
                        continue
                    elif distance < 0.3 * len(message.text):
                        # edit
                        edit = True
                    self.db.insert_text(self.names[i], message.text, edit, img)

                except Exception as e:
                    pass
        finally:
            self.db.save_timestamp()
            self.driver.save_screenshot('fail.png')
            self.driver.quit()
            self.db.cnx.close()



if __name__ == '__main__':
    downloader = Downloader()
    downloader.get_messages()
