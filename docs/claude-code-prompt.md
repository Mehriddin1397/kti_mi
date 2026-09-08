# Loyiha topshirig'i: Kriminologiya Tadqiqot Instituti — Ariza Monitoring Tizimi

## 1. Umumiy tavsif

Kriminologiya tadqiqot instituti uchun **mustaqil izlanuvchilar va tadqiqotchilarning arizalarini bosqichma-bosqich kuzatib boradigan** veb-tizim yaratish kerak. Tizim e-researcher.uz saytining ish jarayoniga (workflow) asoslangan, lekin quyidagi soddalashtirishlar bilan:

- **Ro'yxatdan o'tish yo'q.** Barcha foydalanuvchilarni faqat **admin** yaratadi va ularga login (telefon raqam) va parol beradi.
- **Email emas, SMS orqali xabarnoma** yuboriladi.
- **Email tasdiqlash kerak emas.**
- Dizayn **juda sodda, ortiqcha bezaksiz va tushunarli** bo'lishi kerak.

## 2. Texnologiyalar

- **Laravel** (eng so'nggi barqaror versiya, LTS)
- **Blade + Livewire** — interaktiv qismlar (progress-bar, status yangilanishi) uchun
- **MySQL**
- **spatie/laravel-permission** — rollar va ruxsatlar uchun
- Autentifikatsiya uchun Laravel Breeze (Blade variant) asos qilib olinadi, lekin **ro'yxatdan o'tish (register) sahifasi olib tashlanadi** — faqat login qoladi
- SMS yuborish uchun alohida `SmsService` interfeysi yaratiladi (haqiqiy provayder keyinroq ulanadi, hozircha log/mock ko'rinishida)

## 3. Foydalanuvchilar va rollar

Uchta rol (spatie/laravel-permission orqali):

1. **Admin** — tizimni to'liq boshqaradi
2. **Mas'ul xodim** (responsible staff) — o'ziga biriktirilgan vazifalarni ko'radi, hujjatlarni tasdiqlaydi yoki izoh bilan qaytaradi
3. **Izlanuvchi** (applicant) — o'z arizasi/loyihasini kuzatadi, hujjat yuklaydi

Login maydoni sifatida **telefon raqam** ishlatiladi (email emas).

## 4. Ma'lumotlar bazasi tuzilmasi (asosiy jadvallar)

```
users
  - id
  - full_name
  - phone (unique, login sifatida ishlatiladi)
  - password
  - role (admin / mas'ul_xodim / izlanuvchi) — yoki spatie roles orqali
  - is_active (boolean)

application_types            -- Ariza turlari (admin qo'shadi/tahrirlaydi)
  - id
  - name
  - description
  - is_active

application_type_stages      -- Har bir ariza turiga tegishli bosqichlar SHABLONI
  - id
  - application_type_id
  - name
  - order (tartib raqami)

application_type_tasks       -- Har bir shablon bosqichdagi vazifalar SHABLONI
  - id
  - application_type_stage_id
  - name
  - description
  - default_responsible_user_id (nullable — bo'sh bo'lsa, izlanuvchining o'zi bajaradi)
  - order

projects                     -- Yuborilgan har bir ariza = loyiha
  - id
  - application_type_id
  - user_id (izlanuvchi)
  - full_name, phone (arizada kiritilgan ma'lumotlar)
  - status (jarayonda / yakunlangan / bekor_qilingan)
  - progress_percent (hisoblanadigan/kesh qilinadigan qiymat)
  - created_at

project_stages               -- Loyiha uchun shablondan nusxalangan bosqichlar
  - id
  - project_id
  - name
  - order
  - status (kutilmoqda / jarayonda / tugallangan)

project_tasks                -- Loyiha uchun shablondan nusxalangan vazifalar
  - id
  - project_stage_id
  - name
  - description
  - responsible_user_id (nullable)
  - status (kutilmoqda / jarayonda / qaytarildi / tasdiqlandi)
  - approved_by (mas'ul xodim id)
  - approved_at

documents
  - id
  - project_task_id
  - uploaded_by (user_id)
  - file_name
  - file_path
  - version (raqam — qayta yuklanganda oshadi)
  - status (kutilmoqda / tasdiqlangan / rad_etilgan)
  - created_at

comments
  - id
  - project_task_id (yoki document_id)
  - user_id
  - text
  - created_at

sms_logs
  - id
  - user_id
  - phone
  - message
  - status (yuborildi / xato)
  - created_at
```

## 5. Funksional talablar

### 5.1. Admin paneli

Admin quyidagilarni qila olishi kerak:

- **Ariza turlarini** (application_types) qo'shish, tahrirlash, faol/nofaol qilish
- Har bir ariza turi uchun **bosqichlar shabloni** (application_type_stages) yaratish va tartibini belgilash
- Har bosqich uchun **vazifalar shabloni** (application_type_tasks) qo'shish, xohlasa **mas'ul xodimni oldindan biriktirish** (bo'sh qoldirsa — izlanuvchining o'zi bajaradi)
- **Foydalanuvchi qo'shish**: ism, telefon, parol, rol (izlanuvchi / mas'ul xodim / admin) — bu yerda login-parol admin tomonidan beriladi, ro'yxatdan o'tish yo'q
- Barcha loyihalarni (arizalarni) umumiy jadvalda ko'rish, filtrlash (status, ariza turi, mas'ul xodim bo'yicha)
- Har bir loyihaga kirib, bosqich/vazifalar holatini kuzatish

### 5.2. Ariza jarayoni (workflow)

1. Admin foydalanuvchini yaratadi va unga telefon raqam + parol beradi (SMS orqali yoki qo'lda aytiladi — buni ham keyin belgilaymiz)
2. Foydalanuvchi telefon raqam + parol bilan tizimga kiradi
3. Izlanuvchi **ariza turini tanlaydi**, kerakli formani to'ldiradi va yuboradi
4. Tizim tanlangan ariza turiga tegishli **bosqichlar va vazifalar shablonidan nusxa olib**, yangi `project` (loyiha) yaratadi — shu bilan har bir loyiha o'zining mustaqil bosqich/vazifalar to'plamiga ega bo'ladi (keyinchalik shablon o'zgarsa, eski loyihalarga ta'sir qilmaydi)
5. Loyiha sahifasida barcha bosqichlar va ular ichidagi vazifalar ro'yxati, umumiy **progress-bar (foizda)** bilan ko'rsatiladi
6. Har bir vazifa uchun izlanuvchi **hujjat yuklaydi** (fayl nomi + fayl, versiyalash bilan — qayta yuklasa eski versiya saqlanib qoladi)
7. Vazifaga biriktirilgan **mas'ul xodim** hujjatni ko'rib chiqadi:
   - **Tasdiqlaydi** → vazifa holati "tasdiqlandi"ga o'tadi, progress yangilanadi
   - **Rad etadi** (izoh/comment bilan) → vazifa "qaytarildi" holatiga o'tadi, izlanuvchiga SMS boradi, u hujjatni qayta yuklaydi
8. **Muhim qoida:** vazifa faqat mas'ul xodim tasdiqlagandan so'ng "tugallangan" hisoblanadi — izlanuvchi hujjat yuklashi vazifani avtomatik yakunlamaydi
9. Bosqichdagi barcha vazifalar tasdiqlangach, bosqich "tugallangan" bo'ladi
10. Barcha bosqichlar tugagach, loyiha progressi 100% ga yetadi va loyiha "yakunlangan" statusiga o'tadi

### 5.3. Progress foizini hisoblash

```
progress_percent = (tasdiqlangan vazifalar soni / loyihadagi umumiy vazifalar soni) * 100
```

- Har safar vazifa holati o'zgarganda (tasdiqlandi/qaytarildi) shu qiymat qayta hisoblanadi va `projects.progress_percent` ga yoziladi (yoki har safar dinamik hisoblanadi — soddaligi uchun shu variant ham bo'ladi)
- Loyiha sahifasida va loyihalar ro'yxatida progress-bar ko'rinadi

### 5.4. SMS xabarnoma

`SmsService` interfeysi yaratiladi, quyidagi holatlarda ishlatiladi:

- Yangi foydalanuvchi yaratilganda (login ma'lumotlari)
- Vazifaga hujjat rad etilganda (izoh bilan)
- Vazifa tasdiqlanganda
- Yangi vazifa mas'ul xodimga biriktirilganda

Hozircha haqiqiy SMS provayderi ulanmaydi — `SmsService` faqat `sms_logs` jadvaliga yozadi (log/mock rejimi), keyinchalik haqiqiy provayder (Eskiz.uz, Play Mobile va h.k.) osongina ulanadigan qilib arxitektura qilinadi (interfeys + config orqali).

### 5.5. Dizayn talablari

- **Juda sodda va tushunarli** — minimal ranglar, aniq tugmalar, ortiqcha animatsiya/bezaklarsiz
- Rolga qarab alohida dashboard:
  - **Admin**: statistikalar (jami loyihalar, faol, yakunlangan), tezkor havolalar (ariza turlari, foydalanuvchilar)
  - **Mas'ul xodim**: unga biriktirilgan vazifalar ro'yxati, holat bo'yicha filtr
  - **Izlanuvchi**: o'z loyihalari, har birining progress-bar bilan
- Livewire komponentlari: loyiha sahifasidagi progress-bar va vazifa holati real vaqtda (sahifani qayta yuklamasdan) yangilansin

## 6. Kelajakda kerak bo'lishi mumkin (hozircha qilinmaydi, lekin arxitekturada joy qoldiriladi)

- Ro'yxatdan o'tish funksiyasi (agar keyin kerak bo'lsa)
- Email integratsiyasi
- Dinamik forma builder (ariza turiga qarab boshqa-boshqa maydonlar)
- Ko'p tilli interfeys (o'zbek/rus)

## 7. Amalga oshirish tartibi (Claude Code uchun tavsiya)

1. Laravel loyihasini yarat, Breeze (Blade) o'rnat, register sahifasini olib tashla
2. Migratsiyalar va modellarni yuqoridagi jadval tuzilmasi bo'yicha yarat
3. spatie/laravel-permission o'rnat, 3 ta rol yarat (seeder bilan)
4. Admin uchun birinchi foydalanuvchini seeder orqali yarat (telefon + parol)
5. Admin panel: ariza turlari, bosqich/vazifa shablonlari, foydalanuvchilar CRUD
6. Ariza topshirish formasi va loyiha yaratish logikasi (shablondan nusxalash)
7. Loyiha sahifasi: bosqichlar, vazifalar, progress-bar (Livewire)
8. Hujjat yuklash + versiyalash
9. Mas'ul xodim uchun tasdiqlash/rad etish + izoh
10. `SmsService` (mock/log rejimida)
11. Dizaynni sodda qilib joylashtirish (Tailwind, Breeze default'iga yaqin, ortiqcha bezaksiz)
