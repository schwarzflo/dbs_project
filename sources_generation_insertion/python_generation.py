import random
import numpy as np

def get_file_to_vec(file):
    vec = []
    f = open(file, "r")
    for item in f:
        vec.append(item[0:-1])
    return vec


def postal_codes():
    f = open("javaconform_postalcodes.txt", "w+")

    vec_pc = get_file_to_vec("postal_codes")
    vec_cn = get_file_to_vec("city_names")
    vec_ca = []
    ca = ["AUT", "GER", "CH","SWE","POL","USA","FRA","NED","RUS","CYP","ESP","FIN","NOR","ITA","AUS","ARG","BRA","CAN"]
    i = 0
    while i < 200:
        vec_ca.append(random.choice(ca))
        i += 1

    for count, item in enumerate(vec_pc, 0):
        string = "\"" + item + "\",\"" + vec_cn[count] + "\",\"" + vec_ca[count] + "\""
        f.write(string)
        f.write("\n")


def employee():
    f = open("javaconform_employee.txt", "w+")

    vec_first = []
    vec_us = get_file_to_vec("us.txt")
    vec_sur = []
    vec_uk = get_file_to_vec("uk.txt")
    wh = [30,35,38,38.5,40,42]
    pc = [1400.50,1800.75,1900.90,2000,2050,2350.50,2500,2700,2560,2800,3000.70]
    vec_wh = []
    vec_pc = []
    pos = ["Warehouse Worker","Deliverer","Client Advisor"]
    vec_pos = []
    vec_sn = get_file_to_vec("street_names")
    vec_tn = get_file_to_vec("telephone_numbers") #tn
    i = 0
    while i < 200:
        vec_pos.append(random.choice(pos)) #positions
        vec_sn[i] = vec_sn[i] + " " + str(random.randrange(1, 100, 1)) #street names
        vec_pc.append(random.choice(pc)) #paycheck
        vec_wh.append(random.choice(wh)) #wh
        randi = random.randint(0,len(vec_uk))
        vec_first.append(vec_us[randi]) #frist
        vec_sur.append(vec_uk[randi]) #sur
        i += 1

    i = 0
    while i < 200:
        string = "\"" + vec_first[i] + "\",\"" + vec_sur[i] + "\",\"" + vec_tn[i] + "\",\"" + \
                str(vec_wh[i]) + "\",\"" + str(vec_pc[i]) + "\",\"" + vec_sn[i] + "\",\"" + vec_pos[i] + "\""
        f.write(string)
        f.write("\n")
        i += 1



def customer():
    f = open("javaconform_customer.txt","w+")

    vec_first = []
    vec_all = get_file_to_vec("us.txt")
    vec_sur = []
    vec_us_sur = get_file_to_vec("uk.txt")
    vec_email = []
    email_vec = ["gmail.com","gmx.at","yahoo.com","hotmail.com"]
    vec_sn = get_file_to_vec("street_names2")
    vec_sn = np.random.permutation(vec_sn)
    vec_tn = get_file_to_vec("telephone_numbers_c") #tn


    i = 0
    while i < 1000:
        vec_sn[i] = vec_sn[i] + " " + str(random.randrange(1, 100, 1))  # street names
        randi = random.randint(0, len(vec_us_sur))
        first = vec_all[randi]
        sur = vec_us_sur[randi]
        randi = random.randint(0,1000)
        email = first + sur + str(randi) + "@" + random.choice(email_vec)
        vec_email.append(email) #email
        vec_first.append(first)  # frist
        vec_sur.append(sur)  # sur

        i += 1

    i = 0
    while i < 1000:
        string = "\"" + vec_email[i] + "\",\"" + vec_sn[i] + "\",\"" + vec_first[i] + "\",\"" + \
                vec_sur[i] + "\",\"" + vec_tn[i] + "\""
        f.write(string)
        f.write("\n")
        i += 1


def category():

    f = open("javaconform_category.txt","w+")
    vec_catname = ["Home","Garden","Kitchen","Living Room","Bathroom","Electronics","Gaming","Kids","Literature",
                   "Art&Music","Deco","Pets","Beauty","Health","Grocery","Sports&Outdoors","Car","Clothing","Accessories","Office",
                   "Bedroom"]
    for item in vec_catname:
        string = "\"" + item + "\""
        f.write(string)
        f.write("\n")


def target_group():

    f = open("javaconform_targetgroup.txt","w+")
    vec_groupname = ["Kids","Adults","Teenagers","Gardeners","Seniors","Healthcare Workers","Public Officials",
                     "Software Engineers","Lower Class Workers","Academics"]
    for item in vec_groupname:
        string = "\"" + item + "\""
        f.write(string)
        f.write("\n")



def product():

    f = open("javaconform_product.txt","w+")
    vec_name = get_file_to_vec("thins")
    vec_supplier = get_file_to_vec("supplier")
    vec_catid = get_file_to_vec("catid")
    vec_is = []
    vec_price = []

    i = 0
    while i < 100:
        vec_is.append(random.randint(0,500))
        preis = random.random()*100
        vec_price.append(round(preis,2))
        i += 1

    i = 0
    while i < 100:
        string = "\"" + vec_name[i] + "\",\"" + str(vec_is[i]) + "\",\"" + vec_supplier[i] + "\",\"" \
                 + str(vec_price[i]) + "\",\"" + vec_catid[i] + "\""
        f.write(string)
        f.write("\n")
        i += 1


def order():

    f = open("javaconform_order.txt","w+")
    pm = ["Credit Card", "Paypal", "Instant Bank Transfer", "Payment by Direct Debit", "Check Payment"]
    vec_pm = []
    i = 0
    while i < 500:
        vec_pm.append(random.choice(pm))
        i += 1

    i = 0
    while i < 500:
        string = "\"" + vec_pm[i] + "\""
        f.write(string)
        f.write("\n")
        i += 1


def delivery():

    f = open("javaconform_delivery.txt","w+")
    dates_vec = get_file_to_vec("dates")
    type_vec = []
    type = ["Standard","Express"]
    i = 1
    while i <= 500:
        type_vec.append(random.choice(type))
        i += 1

    i = 1
    while i <= 500:
        string = "\"" + type_vec[i-1] + "\",\"" + dates_vec[i-1] + "\""
        f.write(string)
        f.write("\n")
        i += 1
