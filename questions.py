import requests
import json
url = "https://stepdatabase.maths.org"

#load the json file
jsonurl = f"{url}/database/database_data.json"
response = requests.get(jsonurl, verify=False)
data = response.json()
#print(type(data))

#extract only the question data from the file
questions = data["questions"]

#open json file to store extracted data
questionsjson = open("questions.json", "w")

#iterate through each question
#ignore first "start" question 
for question in questions[1:]:
    #store topic
    topic = question["tags"]
    #only take first topic for data integrity
    topic = topic[0]
    print(topic)
    #store year created and paper number
    title = question["title"]
    # issue with 93-S2-Q7
    if question["question_id"] == 93207:
        year = 1993
    else:
        shortyear = title[:2]
        #the specimen paper from 1986 is stored as "Spec"
        if shortyear == "Sp":
            year = 1986
            paper = int(title[6])
        else:
            paper = int(title[4])
            shortyear = int(shortyear)
            if shortyear < 86:
                year = 2000+shortyear
            else:
                year = 1900+shortyear

    #store area ie. pure, mechanics or probability
    information = question["body"]
    #split body information to find area 
    section = information.split("</b><p><a class=")[0]
    subsection = section.split("(")[-1]
    if subsection == "Pure)]":
        area = 0
    elif subsection == "Mechanics)]":
        area = 1 
    else:
        area = 2

    #url for tex file 

    #specimen case
    if year == 1986:
        texurl = url+"/database/db/Spec/Spec-S"+str(paper)+".tex"
    #otherwise
    else:
        texurl = url+"/database/db/"+str(year)[2:]+"/"+str(year)[2:]+"-S"+str(paper)+".tex"
    
    #load text from url
    response = requests.get(texurl, verify = False)
    texfile = response.text
    
    #split by questions
    sections = texfile.split("begin{question}")
    
    #identify question code
    # issue with 93-S2-Q7
    if question["question_id"] == 93207:
        questionnum = 7
    else:
        questionnum = int(title[-1])
    code = sections[questionnum]

    #clean code
    index = code.find("end{question}")
    code = code[:index-1]
    
    #all data 
    info= {"topic" : topic, "year" : year, "paper" : paper, "area" : area, "code" :code}
    questionsjson.write(json.dumps(info))

    #add data into json file 

questionsjson.close()