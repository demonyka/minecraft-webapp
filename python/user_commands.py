from models import *
from telebot import *
from dotenv import load_dotenv
import os
load_dotenv('../.env')

def send_profile(message, self):
    keyboard = types.InlineKeyboardMarkup(row_width=1)
    webAppTest = types.WebAppInfo(os.getenv("APP_URL"))
    one_butt = types.KeyboardButton(text="Открыть", web_app=webAppTest)
    keyboard.add(one_butt)
    self.bot.send_message(message.from_user.id, 'Добро пожаловать на проект PixelPunch!', reply_markup=keyboard)
# ---- [ /start ] ----
def start_command(message, self):
    if message.chat.type != "private":
        return
    else:
        send_profile(message, self)