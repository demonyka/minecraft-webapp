from telebot import *
import user_commands
from models import *
from dotenv import load_dotenv
import os
load_dotenv('../.env')

class Telegram():
    def __init__(self, token):
        self.token = token
        self.bot = telebot.TeleBot(token)
        self.setup_message_handler()
        self.params = {} 
        self.data_dict = {}
        self.command_handlers = {}

    def setup_message_handler(self):
        @self.bot.message_handler(content_types=['text'])
        def handle_command(message):
            command_handlers = {
                'start': (user_commands.start_command, (message, self)),
            }
            if message.text[0] == '/':
                command = message.text.split()[0].replace('/', '')
                handler = command_handlers.get(command)
                if handler:
                    func, args = handler
                    func(*args)
                else:
                    self.bot.send_message(message.chat.id, 'Неизвестная команда')
            else:
                self.bot.delete_message(message.chat.id, message.message_id)


    def run(self):
        self.bot.infinity_polling()


if __name__ == '__main__':
    token = os.getenv("BOT_API")
    Tele = Telegram(token=token)
    Tele.run()

