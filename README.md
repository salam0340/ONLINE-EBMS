<h1 align="center">⚡ Online Electricity Bill Management System (OEBMS)</h1>

<p align="center">
  A modern web application to automate electricity bill generation, meter reading via image upload, and online payment — built for a smarter Bangladesh 🇧🇩
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Language-PHP-blue?style=flat-square" />
  <img src="https://img.shields.io/badge/Database-MySQL-yellow?style=flat-square" />
  <img src="https://img.shields.io/badge/Responsive-Yes-green?style=flat-square" />
  <img src="https://img.shields.io/badge/License-Educational-lightgrey?style=flat-square" />
</p>

---

## 🚀 Project Overview

The **Online Electricity Bill Management System (OEBMS)** is a digital solution that simplifies the traditional electricity billing process. Instead of manual meter reading and offline payment, users can **upload their meter image**, **get their bill calculated automatically**, and **pay online** — all in a few clicks.

Admins have full control to manage users, verify meter data, generate bills, and monitor payment activity through a smart dashboard.

---

## 🧩 Key Features

### 👤 For Users
- ✅ Account Registration & Login
- 📷 Upload meter image monthly
- 💳 Online bill payment (Visa, Mastercard)
- 📄 Download bill in PDF format
- 📈 Track usage history (up to 6 months)
- 🌐 Multilingual UI: English & Bangla
- 📲 Receive email/SMS notifications

### 🛠️ For Admins
- 👁️ View uploaded meter images
- 🔢 Input meter readings & generate bills
- 🧾 Manage tariff rates & billing rules
- 🧍 Register & manage users
- 🔔 Send notifications/reminders
- 📊 View reports by user category (domestic, industrial, hospital, etc.)
- 📱 Mobile-friendly responsive dashboard

---

## 🛠️ Tech Stack

| Technology | Description |
|------------|-------------|
| **PHP** | Backend scripting |
| **MySQL** | Database |
| **HTML/CSS/JS** | Frontend UI |
| **Bootstrap** | Responsive design |
| **SSLCommerz API** | Payment gateway integration |
| **SMS API** | Notification system |

---

## 📲 How It Works

```mermaid
graph TD;
    A[User Registration] --> B[Login & Dashboard];
    B --> C[Upload Meter Image];
    C --> D[Admin Verifies Image];
    D --> E[Input Reading & Generate Bill];
    E --> F[User Views Bill];
    F --> G[Pay via SSLCommerz];
    G --> H[Receive Notification];
    F --> I[Download PDF Bill];
