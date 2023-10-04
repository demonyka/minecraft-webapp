from dotenv import load_dotenv
import os
load_dotenv('../.env')
from peewee import *
from playhouse.postgres_ext import PostgresqlExtDatabase

db = PostgresqlExtDatabase(
    os.getenv("DB_DATABASE"),
    host=os.getenv("DB_HOST"),
    user=os.getenv("DB_USERNAME"),
    password=os.getenv("DB_PASSWORD")
)


class BaseModel(Model):
	id = PrimaryKeyField(unique=True)

	class Meta:
		database = db
		order_by = 'id'

class User(BaseModel):
    user_id = BigIntegerField(unique=True)
    user_username = CharField(null=True)
    nickname = CharField(unique=True)
    email = CharField(unique=True)
    balance = IntegerField(default=0)
    reg_date = DateTimeField()
    password = CharField()
    referal = CharField(null=True)
    admin = BooleanField(default=False)

    class Meta:
        db_table = 'users'


