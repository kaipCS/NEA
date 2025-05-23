    #iterate through each one
    for word in keywordsarray:
        #ensure same formatting for uniqueness
        word= word.strip().lower()
        print(word)
        #check if already in array 
        if word not in keywordarray:
            keywordarray.append(word)
            #write to file
            file.write(word+"\n")
print(keywordarray)
file.close()

