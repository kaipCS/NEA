import requests
import json

#open file to store keywords
file = open("questionkeywords.json", "w")

#array to hold dictionaries
dictionaries = []

#url of json file
url = "https://stepdatabase.maths.org/database/database_data.json"

#open file and extract questions 
response = requests.get(url, verify=False)
data = response.json()
questions = data["questions"]
 
#question ID counter
counter =  0

#iterate through each ignoring first start question
for question in questions[1:]:
    counter += 1
    #extract section with only kewyords
    information = question["body"]
    array = information.split(".")
    keywords = array[0]
    #issue of some not having full stops
    if "<p>" in keywords:
        array = information.split("<p>")
        keywords = array[0]
    
    #split list of keywords into an array of individual ones
    keywordsarray = keywords.split(",")
    info= {"questionid" : counter, "keywords" : keywordsarray}
    dictionaries.append(info)

json.dump(dictionaries, file)
#print(keywordarray)
file.close()

