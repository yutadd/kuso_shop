import random
from datetime import datetime, timedelta
import bcrypt

# Set the number of users to generate data for
num_users = 20

# Set the range of possible prices for products
min_price = 100
max_price = 10000

# Set the range of possible total amounts for orders
min_total_amount = 1000
max_total_amount = 100000

# Set the date range for orders
start_date = datetime(2020, 1, 1)
end_date = datetime(2023, 12, 31)

# Set the list of possible first names and last names
first_names = ["Taro", "Hanako", "Jiro", "Yoko",
               "Saburo", "Yumi", "Shiro", "Saki", "Goro", "Miki"]
last_names = ["Sato", "Suzuki", "Takahashi", "Tanaka",
              "Watanabe", "Ito", "Yamamoto", "Nakamura", "Kobayashi", "Kato"]

# Set the list of possible product names and descriptions
product_names = ["T-Shirt", "Hoodie", "Sweater", "Jacket",
                 "Pants", "Shorts", "Skirt", "Dress", "Hat", "Scarf"]
product_descriptions = ["Comfortable and stylish T-Shirt.", "Warm and cozy hoodie.",
                        "Soft and comfortable sweater.",
                        "Stylish and practical jacket.",
                        "Comfortable and versatile pants.",
                        "Cool and comfortable shorts.",
                        "Stylish and feminine skirt.",
                        "Elegant and beautiful dress.",
                        "Stylish and practical hat.",
                        "Warm and cozy scarf."]

# Generate data for customers
for i in range(num_users):
    customer_id = i + 1
    first_name = random.choice(first_names)
    last_name = random.choice(last_names)
    email = f"{first_name.lower()}.{last_name.lower()}@example.com"
    phone = f"080-{random.randint(1000,9999)}-{random.randint(1000,9999)}"
    print(
        f"INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Phone) VALUES ({customer_id}, '{first_name}', '{last_name}', '{email}', '{phone}');")

    # Generate a random password for the customer
    password = f"{first_name}{random.randint(1000,9999)}"
    # Hash the password using bcrypt
    password_hash = bcrypt.hashpw(password.encode(
        'utf-8'), bcrypt.gensalt()).decode('utf-8')
    # Insert the password hash into the Password table
    print(
        f"INSERT INTO Password (CustomerID, PasswordHash) VALUES ({customer_id}, '{password_hash}');")

# Generate data for products
for i in range(len(product_names)):
    product_id = i + 1
    product_name = product_names[i]
    price = random.randint(min_price, max_price)
    description = product_descriptions[i]
    print(
        f"INSERT INTO Product (ProductID, ProductName, Price, Description) VALUES ({product_id}, '{product_name}', {price}, '{description}');")

# Generate data for orders
order_id = 1
for i in range(num_users):
    customer_id = i + 1
    num_orders = random.randint(1, 10)
    for j in range(num_orders):
        order_date = start_date + \
            timedelta(days=random.randint(0, (end_date - start_date).days))
        total_amount = random.randint(min_total_amount, max_total_amount)
        print(
            f"INSERT INTO ProductOrder (OrderID, CustomerID, OrderDate, TotalAmount) VALUES ({order_id}, {customer_id}, '{order_date.strftime('%Y-%m-%d')}', {total_amount});")
        order_id += 1
