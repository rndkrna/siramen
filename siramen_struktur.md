# 🗂️ Struktur MVC & API — Siramen

## 📁 Migrations (`database/migrations/`)

| File | Tabel |
|---|---|
| `0001_01_01_000000_create_users_table.php` | users (default Laravel) |
| `2026_05_09_000001_modify_users_table.php` | **modify** users → sesuai schema Siramen |
| `2026_05_09_000002_create_subjects_table.php` | subjects |
| `2026_05_09_000003_create_deadlines_table.php` | deadlines |
| `2026_05_09_000004_create_notifications_table.php` | notifications |
| `2026_05_09_000005_create_user_preferences_table.php` | user_preferences |
| `2026_05_09_000006_create_documents_table.php` | documents |
| `2026_05_09_000007_create_summaries_table.php` | summaries |
| `2026_05_09_000008_create_quizzes_table.php` | quizzes + quiz_questions |
| `2026_05_09_000009_create_quiz_attempts_table.php` | quiz_attempts |
| `2026_05_09_000010_create_log_tables.php` | activity_logs + api_usage_logs |

---

## 🧩 Models (`app/Models/`)

| Model | Tabel | Relasi Utama |
|---|---|---|
| `User` | users | hasMany: Subject, Deadline, Notification, Document, QuizAttempt, ActivityLog, ApiUsageLog · hasOne: UserPreference |
| `Subject` | subjects | belongsTo: User · hasMany: Deadline, Document |
| `Deadline` | deadlines | belongsTo: User, Subject · hasMany: Notification |
| `Notification` | notifications | belongsTo: User, Deadline |
| `UserPreference` | user_preferences | belongsTo: User |
| `Document` | documents | belongsTo: User, Subject · hasOne: Summary · hasMany: Quiz |
| `Summary` | summaries | belongsTo: Document |
| `Quiz` | quizzes | belongsTo: User, Document · hasMany: QuizQuestion, QuizAttempt |
| `QuizQuestion` | quiz_questions | belongsTo: Quiz |
| `QuizAttempt` | quiz_attempts | belongsTo: Quiz, User |
| `ActivityLog` | activity_logs | belongsTo: User |
| `ApiUsageLog` | api_usage_logs | belongsTo: User |

> Semua model menggunakan **UUID** (`HasUuids`) dan `public $incrementing = false`

---

## 🎮 Controllers (`app/Http/Controllers/Api/`)

| Controller | Tanggung Jawab |
|---|---|
| `AuthController` | OAuth redirect, callback, logout, me |
| `SubjectController` | CRUD mata kuliah |
| `DeadlineController` | CRUD deadline + toggle done |
| `NotificationController` | List, mark-sent, hapus notifikasi |
| `UserPreferenceController` | Tampilkan & update preferensi |
| `DocumentController` | Upload, list, detail, hapus dokumen |
| `SummaryController` | Tampilkan, generate, regenerate summary AI |
| `QuizController` | List, generate, detail, hapus quiz |
| `QuizAttemptController` | List attempts, submit jawaban, detail attempt |
| `ActivityLogController` | List activity log (read-only) |

---

## 🌐 API Endpoints (`routes/api.php`)

### 🔓 Public (tanpa auth)
| Method | Endpoint | Controller@Method | Keterangan |
|---|---|---|---|
| GET | `/api/auth/{provider}/redirect` | AuthController@redirect | Redirect OAuth |
| GET | `/api/auth/{provider}/callback` | AuthController@callback | Callback OAuth |

### 🔐 Protected (`auth:sanctum`)

#### Auth
| Method | Endpoint | Keterangan |
|---|---|---|
| POST | `/api/auth/logout` | Logout, cabut token |
| GET | `/api/auth/me` | Data user yang login |

#### User Preferences
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/preferences` | Tampilkan preferensi |
| PUT | `/api/preferences` | Update preferensi |

#### Subjects
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/subjects` | Daftar mata kuliah |
| POST | `/api/subjects` | Buat mata kuliah |
| GET | `/api/subjects/{subject}` | Detail mata kuliah |
| PUT | `/api/subjects/{subject}` | Update mata kuliah |
| DELETE | `/api/subjects/{subject}` | Hapus mata kuliah |

#### Deadlines
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/deadlines` | Daftar deadline |
| POST | `/api/deadlines` | Buat deadline |
| GET | `/api/deadlines/{deadline}` | Detail deadline |
| PUT | `/api/deadlines/{deadline}` | Update deadline |
| PATCH | `/api/deadlines/{deadline}/toggle` | Toggle selesai |
| DELETE | `/api/deadlines/{deadline}` | Hapus deadline |

#### Notifications
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/notifications` | Daftar notifikasi |
| PATCH | `/api/notifications/{notification}/mark-sent` | Tandai terkirim |
| DELETE | `/api/notifications/{notification}` | Hapus notifikasi |

#### Documents
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/documents` | Daftar dokumen |
| POST | `/api/documents` | Upload dokumen |
| GET | `/api/documents/{document}` | Detail dokumen |
| DELETE | `/api/documents/{document}` | Hapus dokumen |

#### Summary (nested di Document)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/documents/{document}/summary` | Tampilkan summary |
| POST | `/api/documents/{document}/summary/generate` | Generate summary AI |
| POST | `/api/documents/{document}/summary/regenerate` | Regenerate summary AI |

#### Quiz (generate dari Document)
| Method | Endpoint | Keterangan |
|---|---|---|
| POST | `/api/documents/{document}/quiz/generate` | Generate quiz AI |

#### Quizzes
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/quizzes` | Daftar quiz |
| GET | `/api/quizzes/{quiz}` | Detail quiz + soal |
| DELETE | `/api/quizzes/{quiz}` | Hapus quiz |

#### Quiz Attempts
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/quizzes/{quiz}/attempts` | Daftar attempts |
| POST | `/api/quizzes/{quiz}/attempts` | Submit jawaban |
| GET | `/api/quizzes/{quiz}/attempts/{attempt}` | Detail attempt |

#### Activity Log
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/activity-logs` | Daftar aktivitas user |

---

## ⚙️ Langkah Selanjutnya

1. **Install Sanctum**: `composer require laravel/sanctum`
2. **Install Socialite** (untuk OAuth): `composer require laravel/socialite`
3. **Publish Sanctum config**: `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
4. **Register api.php** di `bootstrap/app.php`
5. **Jalankan migration**: `php artisan migrate`
6. **Install Requests** per endpoint (validasi)
