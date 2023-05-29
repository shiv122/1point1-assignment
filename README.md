# requirements

php ^8.1 
node ^16
npm


# step

```
composer install
```

```
php artisan key:generate
```

```
php artisan:migrate
```

```
php artisan db:seed
```

```
npm install
```

```
npm run dev
```

```
php artisan serve
```

# Employee Route

<a href="http://127.0.0.1:8000/employee/">http://127.0.0.1:8000/employee/<a>

# Admin Route

<a href="http://127.0.0.1:8000/admin/">http://127.0.0.1:8000/admin/<a>

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

# Mail Config Step

<blockquote >
If you're not running code on port 8000 let me know so i'll update that pass to google console.
then change `GOOGLE_REDIRECT_URI` in .env
</blockquote>
