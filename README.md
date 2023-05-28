# requirements

php 8.1 or grater
node
npm

# step

composer install

php artisan key:generate

php artisan:migrate

php artisan db:seed

npm install

npm run dev

# Employee Route

{base link} /employee

# Admin Route

{base link} /admin

# Employee Mass Import

Example File in ./example-employee-mass-import.xlsx

<blockquote style="background-color: #ffeeba;
    border-left: 6px solid #ffc107;
    padding: 10px;
    margin: 10px 0;" class="warning">
there should not be any empty or extra cells, rows or columns
</blockquote>

| Name             | Email                   | Date of Birth | Gender | Password | Is Manager |
| ---------------- | ----------------------- | ------------- | ------ | -------- | ---------- |
| Shivesh Tripathi | shivtiwari627@gmail.com | 1998-02-05    | Male   | 123456   | No         |
