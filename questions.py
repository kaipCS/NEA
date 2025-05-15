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
#iterate through each question
#ignore first "start" question 
for question in questions[1:]:
    #store topic
    topic = question["tags"]
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
    print(topic, year, paper, area)

    #url for tex file 

    #spec case

    #otherwise
    texurl = url + "/database/db/" + str(year)[2:] + "/" + str(year)[2:] + "-S" + str(paper) + ".tex"
    print(texurl)



# #convert question data json file into a list
# questions = data if isinstance(data, list) else data.get("questions") or data.get("data") or []
# print("questions")
# print(questions)


#import re
#from urllib.parse import urljoin
# # Process each question
# for i, question in enumerate(questions):
#     title = question.get("title", f"Question {i+1}")
#     body = question.get("body", "")
    
#     # Try to extract the .tex file link
#     match = re.search(r'href="(/database/db/[^"]+\.tex)"', body)
#     if match:
#         tex_url = urljoin(BASE_URL, match.group(1))
#         print("starting outputing")
#         print(f"{i+1}. {title}")
#         print(f"TeX URL: {tex_url}")
        
#         # Try to download and show the content (or first few lines)
#         tex_resp = requests.get(tex_url, verify=False)
#         if tex_resp.status_code == 200:
#             lines = tex_resp.text.splitlines()
#             for line in lines[:10]: # show first 10 lines 
#                 print(line)