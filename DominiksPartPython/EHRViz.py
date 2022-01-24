import csv
import matplotlib.pyplot as plt
import pandas as pd
import mysql.connector
from mysql.connector import Error
from matplotlib.colors import ListedColormap



def conditions(patients):
    """if((patients['yPressure'] <= 130) and (patients['xPressure'] <= 85)):
        return "Normal Blood Pressure"
    elif((patients['yPressure'] in range(131,139)) and (patients['xPressure'] in range(86,89))):
        return "Elevated Normal Pressure"
    elif((patients['yPressure'] in range(140,159)) and (patients['xPressure'] in range(90,99))):
        return "Mild Hypertension"
    elif((patients['yPressure'] in range(160,179)) and (patients['xPressure'] in range(100,109))):
        return "Moderate Hypertension"
    elif((patients['yPressure'] > 180) and (patients['xPressure'] > 110)):
        return "Severe Hypertension"
    elif((patients['yPressure'] > 140) and (patients['xPressure'] < 90)):
        return "Isolated systolic hypertension"
        """
    # the code above will represent more precise blood pressure type
    if((patients['yPressure'] in range(90,119)) and (patients['xPressure'] in range (60,89))):
        return "Normal Blood Pressure"
    elif((patients['yPressure'] in range(120,139)) and (patients['xPressure'] in range (80,89))):
        return "Moderate Blood Pressure"
    elif((patients['yPressure'] > 140) or (patients['xPressure'] > 90)):
        return "High Blood Pressure"
    else:
        return "Low Blood Pressure"

"""
try:
    connection = mysql.connector.connect(host = "localhost", database = "ehr", user = "root", password = "")

    mySql_select__Query = "SELECT age,sex,bloodPressure FROM patients"
    cursor = connection.cursor(dictionary = True)
    cursor.execute(mySql_select__Query)
    row_count = 100
    #row_count can be changed depending on how many data you want (max rows in db are 1000 atm)
    records = cursor.fetchmany(row_count)
    print("Total number of rows: ", cursor.rowcount)

    df = pd.DataFrame(records)
    bins = [0, 24, 64, 120]
    labels = ['adolescent', 'adult', 'old age']
    df['AgeGroup'] = pd.cut(df['age'], bins=bins, labels=labels, right = False)
    patients = df['bloodPressure'].str.split('/', expand = True).astype(int)
    patients.rename(columns = {0: 'yPressure', 1: 'xPressure'}, inplace = True)
    #patients =patients.squeeze()
    #print (patients)
    #print (type(patients))
    #pd.to_numeric(patients)
    #patients['bloodPressureGroup'] = pd.cut((patients['yPressure']), bins = yPressure, labels = yPressureLabel, right = False)
    #print (patients)
    patients['Type'] = patients.apply(conditions, axis=1)
    #type and age group are added for future improvements
    result = df.join(patients)
    result.to_csv('file1.csv')
    #print (result)

    
except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySql connection is closed")
"""
#the above commented code is used to fetch the rows from db and applying it in real time for data viz. if you want uncomment it
#and try running the entire project
result = pd.read_csv('DominiksPartPython/file1.csv')
#if you wish to try with the db comment the line above this comment
numSex = [1 if x=='Male'else 0 if x=='Female' else 'error' for x in result['sex']]
#changing the Male and Female strings to integers so i can work with them as nubers in my scatter plot
sexs = ['Female', 'Male']
fig = plt.figure(figsize = (6,6))
ax = plt.axes(projection = '3d')
ax.set_title('Age and Sex-wise Blood Pressure comparison in EHR DB')
ax.set_xlabel('xPressure')
ax.set_ylabel('yPressure')
ax.set_zlabel('Age')
colors = ListedColormap(['red','blue'])
ages = result['age']
xPressure = result['xPressure']
yPressure = result['yPressure']
    #gender_labels = result['sex']
ax.spines['top'].set_visible(False)
ax.spines['right'].set_visible(False)
    
ax.grid(color='grey', linestyle='-', linewidth=0.25, alpha=0.4)

scatter = ax.scatter(xPressure, yPressure, ages, c=numSex, cmap=colors)
ax.legend(handles=scatter.legend_elements()[0], labels=sexs)

#plt.savefig("plot.png")
plt.show()

