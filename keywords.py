import requests
import json

#array to keep track of unique keywords
allkeywords = []

#open file to store keywords
file = open("keywords.txt", "w")

#url of json file
url = "https://stepdatabase.maths.org/database/database_data.json"

#open file and extract questions 
response = requests.get(url, verify=False)
data = response.json()
questions = data["questions"]

#iterate through each ignoring first start question
for question in questions[1:]:
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
    #iterate through each one
    for word in keywordsarray:
        #ensure same formatting for uniqueness
        word= word.strip().lower()
        print(word)
        #check if already in array 
        if word not in allkeywords:
            allkeywords.append(word)
            #write to file
            file.write(word+"\n")
print(allkeywords)
file.close()

