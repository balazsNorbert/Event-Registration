**Esemény regisztrációs rendszer**
---
Ez egy Laravel + Inertia.js + Vue.js (Options API) alapú full-stack eseménykezelő és regisztrációs rendszer. A projekt célja egy biztonságos és skálázható megoldás nyújtása események hirdetésére és azokra való jelentkezésre.

**Főbb jellemzők**
---
**Teljes CRUD:** Események létrehozása, szerkesztése, megtekintése és törlése (Soft Delete).

**Biztonság:** Laravel Policy alapú jogosultságkezelés (csak a tulajdonos módosíthat).

**Jelentkezési rendszer:** Tranzakció alapú (lockForUpdate) jelentkezés a race condition elkerülése érdekében.

**Értesítések:** Automatikus e-mail visszaigazolás a jelentkezőnek és értesítés a szervezőnek (Queue/ShouldQueue használatával).

**Publikus REST API:** Verziózott (v1), throttolt API végpontok az események eléréséhez.

**Modern Frontend:** Inertia.js Vue.js Options API-val, Tailwind CSS formázással.

**Technológiai stack**
---
**Backend:** Laravel

**Frontend:** Vue.js (Options API), Inertia.js

**Stílus:** Tailwind CSS

**Adatbázis:** MySQL

**Sorbanállás (Queue):** Database driver

**Telepítési lépések**
---
**1. Repo klónozása:**
```bash
git clone https://github.com/balazsNorbert/Event-Registration.git
cd repo-neve
```
**2. Függőségek telepítése:**
```bash
composer install
npm install
```
**3. Környezeti beállítások:**
```bash
cp .env.example .env
php artisan key:generate
```
**4. Adatbázis migráció és feltöltés:**
```bash
php artisan migrate --seed
```
**5. Storage link létrehozása:**
```bash
php artisan storage:link
```
**6. E-mail beállítás (Fejlesztéshez):**
```bash
MAIL_MAILER=log
QUEUE_CONNECTION=database
```
**7. Alkalmazás indítása:**

Egyik terminálban:
```bash
npm run dev
```
Másik terminálban:
```bash
php artisan serve
```
Harmadik terminálban a levelek kiküldéséhez:
```bash
php artisan queue:work
```
**Felhasználó a seedelés után:**

John@email.com / password

**API Végpontok**
---
Az API publikus, auth nem szükséges, de rate limit (throttle) védi.

**1. Események listázása**
GET /api/v1/events
**Leírás:** Visszaadja a jövőbeli eseményeket lapozva.
**Válasz példa:**
```json
{
  "data": [
    {
      "id": 3,
      "title": "Molestias cupiditate odio vel velit.",
      "description": "Laboriosam ut quam dolores dignissimos tenetur sed qui. Ea minus et veritatis error a non tempora. Est necessitatibus et quia quasi. Ut unde velit autem veritatis est tenetur.",
      "event_date": "2026-04-15 09:11",
      "max_limit": 445,
      "available_slots": 445,
      "organizer": {
        "id": 1,
        "name": "John Bobby"
      },
      "image": "https://event-registration.test/storage/events/test.jpg",
      "links": {
        "self": "https://event-registration.test/api/v1/events/3"
      }
    },
    {...},
    {
      "id": 17,
      "title": "Asperiores earum molestiae.",
      "description": "Eum aliquid sed voluptatum accusamus nihil nesciunt. Quasi dolor ut et quasi est. Dolorem est optio esse ut ad rerum.",
      "event_date": "2026-05-07 07:29",
      "max_limit": 251,
      "available_slots": 251,
      "organizer": {
        "id": 1,
        "name": "John Bobby"
      },
      "image": "https://event-registration.test/storage/events/test.jpg",
      "links": {
        "self": "https://event-registration.test/api/v1/events/17"
      }
    }
  ],
  "links": {
    "first": "https://event-registration.test/api/v1/events?page=1",
    "last": "https://event-registration.test/api/v1/events?page=3",
    "prev": null,
    "next": "https://event-registration.test/api/v1/events?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "https://event-registration.test/api/v1/events?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": "https://event-registration.test/api/v1/events?page=2",
        "label": "2",
        "page": 2,
        "active": false
      },
      {
        "url": "https://event-registration.test/api/v1/events?page=3",
        "label": "3",
        "page": 3,
        "active": false
      },
      {
        "url": "https://event-registration.test/api/v1/events?page=2",
        "label": "Next &raquo;",
        "page": 2,
        "active": false
      }
    ],
    "path": "https://event-registration.test/api/v1/events",
    "per_page": 9,
    "to": 9,
    "total": 20
  }
}
```
**2. Esemény részletei**
GET /api/v1/events/1
**Válasz:** Részletes objektum az esemény adataival vagy 404 hiba.
```json
{
  "data": {
    "id": 1,
    "title": "Accusamus repudiandae libero et.",
    "description": "Velit hic impedit qui repudiandae explicabo suscipit et. Dolore ratione aut voluptatum dolore. Cupiditate non vitae nostrum corrupti in voluptatibus.",
    "event_date": "2026-06-13 13:36",
    "max_limit": 34,
    "available_slots": 34,
    "organizer": {
      "id": 1,
      "name": "John Bobby"
    },
    "image": "https://event-registration.test/storage/events/test.jpg",
    "links": {
      "self": "https://event-registration.test/api/v1/events/1"
    }
  }
}
```
