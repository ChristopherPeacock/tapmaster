import discord
from discord.ext import commands
import os
from dotenv import load_dotenv

# Load environment variables from a .env file in the same directory
load_dotenv()

# Intents let you specify what events you want
intents = discord.Intents.default()
intents.message_content = True  # Needed to read message content

# Prefix for commands, e.g., !ping
bot = commands.Bot(command_prefix='!', intents=intents)

@bot.event
async def on_ready():
    print(f'✅ Logged in as {bot.user} (ID: {bot.user.id})')
    
@bot.command()
async def ping(ctx):
    await ctx.send('Pong! 🏓')
    
@bot.command()
async def hello(ctx):
    await ctx.send('Hello! 👋')

# Get the Discord token from the environment variables
discord_token = os.getenv('DISCORD_TOKEN')

if discord_token:
    bot.run(discord_token)
else:
    print("Error: DISCORD_TOKEN not found in the environment variables.")

