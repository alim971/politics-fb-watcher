from time import sleep

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from Levenshtein import distance as lev
import random
import mysql.connector
import sys



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

    def check_and_create_tables(self, names):
        mycursor = self.cnx.cursor()
        mycursor.execute("SHOW TABLES")
        tables = []
        for table in mycursor:
            tables.append(table[0])

        for name in names:
            if name not in tables:
                mycursor.execute(
                    f'CREATE TABLE {name} (id INT AUTO_INCREMENT PRIMARY KEY, text TEXT, date DATETIME DEFAULT CURRENT_TIMESTAMP, edit BOOLEAN)')
                print(f'Table {name} created')

    def insert_text(self, name, text, edit):
        if "Zobrazit víc" in text:
            print("0 record inserted.")
            return
        mycursor = self.cnx.cursor()

        sql = f'INSERT INTO {name} (text, edit) VALUES (%s, %s)'
        mycursor.execute(sql, [text, edit])

        self.cnx.commit()
        print(mycursor.rowcount, "record inserted.")

    def get_last_saved_messsage(self, name):
        mycursor = self.cnx.cursor()

        mycursor.execute(f'SELECT text FROM {name} ORDER BY date DESC LIMIT 1')

        myresult = mycursor.fetchone()

        print(myresult)
        return "" if myresult is None else myresult[0]


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

    def __init__(self, names):
        self.__init_driver__()
        self.names = [name.replace('.', '_') for name in names]
        self.db = MySqlWwrapper()
        self.db.check_and_create_tables(self.names)
        self.urls = [self.fb_url + name for name in names]

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

    def login(self):
        email = self.driver.find_element_by_name("email")
        email.send_keys(self.credentials.email)
        sleep(1)

        password = self.driver.find_element_by_name("pass")
        password.send_keys(self.credentials.password)
        sleep(1)

        login = self.driver.find_element_by_name('login')
        login.click()
        sleep(1)

    def get_last_message(self):
        try:
            WebDriverWait(self.driver, 2).until(
                EC.presence_of_element_located((By.XPATH, "//*[contains(text(),'Zobrazit víc')]"))
            )
            see_more = self.driver.find_element_by_xpath("//*[contains(text(),'Zobrazit víc')]")
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

        return self.driver.find_element_by_css_selector("[data-ad-comet-preview=message]")

    def check_messages_difference(self, name):
        last_message = self.db.get_last_saved_messsage(name)
        message = self.get_last_message()
        return lev(last_message, message.text), message

    def get_messages(self):
        try:
            for i in range(len(self.names)):
                try:
                    self.driver.get(self.urls[i])
                    self.accept_cookies()

                    distance, message = self.check_messages_difference(self.names[i])
                    # debug_file.write_text("distance " + distance.__str__())
                    edit = False
                    if distance == 0:
                        continue
                    elif distance < 0.3 * len(message.text):
                        # edit
                        edit = True
                    # self.driver.save_screenshot('/Users/i343623/PycharmProjects/blaha/message.png')
                    # self.message_files[i].touch(exist_ok=True)
                    self.message_files[i].write_text(message.text)
                    self.db.insert_text(self.names[i], message.text, edit)

                except Exception as e:
                    # self.driver.save_screenshot('/Users/i343623/PycharmProjects/blaha/fail.png')
                    # self.debug_files[i].write_text(e.__str__())
                    pass
        finally:
            self.driver.save_screenshot('fail.png')
            self.driver.quit()


if __name__ == '__main__':
    if len(sys.argv) == 1:
        politicians = ['robertficosk', 'LBlaha', 'ChmelarEduard', 'ing.milan.uhrik', 'MilanMazurek.Republika']
    else:
        politicians = sys.argv[1].split(',')
    downloader = Downloader(politicians)
    downloader.get_messages()
