# Survey App - Daryll Gimeno

## Setup

1. **Clone repository**  
```bash
git clone https://github.com/Daryllgimeno/indigo8-technical-assesment---daryll-gimeno.git
cd indigo8-technical-assesment---daryll-gimeno
```

2. **Install dependencies**  
```bash
composer install
npm install
npm run dev  # optional for frontend
```

3. **Configure environment**  
- Copy `.env.example` to `.env`  
```bash
cp .env.example .env
```
- Update database settings in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surveyDB
DB_USERNAME=root
DB_PASSWORD=
```

4. **Run migrations**  
```bash
php artisan migrate
```

5. **Serve application**  
```bash
php artisan serve
```
- Open browser: `http://127.0.0.1:8000`

## 
- Add/Edit/Delete survey questions  
- Add/Edit/Delete options for multiple-choice questions  
- Submit survey responses
- for email notification, use https://mailtrap.io/ (mailtrap)
Paste this settings in .env
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525 
MAIL_USERNAME= (your username in the mailtrap)
MAIL_PASSWORD=(your password in mailtrap)
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="Survey App"
```
then 
```bash
php artisan config:clear
php artisan cache:clear

Run php artisan server 
```
follow the documentation for the step
https://mailtrap.io/blog/send-email-in-laravel/
## Notes

- No seeders included; database starts empty  
- Frontend uses Laravel Blade templates  
- Validation prevents submitting unanswered questions
  

