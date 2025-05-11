# Konum API Servisi

🌐 **Canlı Uygulama:** [https://task.halkaarzhaber.xyz/](https://task.halkaarzhaber.xyz/)

Laravel tabanlı bu API, kullanıcı kaydı ve lokasyon verilerinin yönetimi için uç noktalar sunar.

---

## 🔑 API Uç Noktaları

### 🔐 Kullanıcı Kayıt

**POST** `/api/register`  
**Parametreler:**

- `name`
- `email`
- `password`
- `password_confirmation`

---

### 📍 Lokasyon Ekle

**POST** `/api/add-location`  
**Parametreler:**

- `name`
- `latitude`
- `longitude`
- `marker_color`
- `description`
- `orders`

---

### 📄 Tüm Lokasyonları Getir

**GET** `/api/get-locations`

---

### 📄 Tek Bir Lokasyonu Getir

**GET** `/api/get-location/{id}`

---

### ✏️ Lokasyon Düzenle

**POST** `/api/edit-location/{id}`  
**Parametreler:**

- `name`
- `latitude`
- `longitude`
- `marker_color`
- `description`
- `orders`

---

### ❌ Lokasyon Sil

**DELETE** `/api/destroy-location/{id}`

---

### 🗺️ Enlem ve Boylama Göre Lokasyonları Listele

**POST** `/api/maps`  
**Parametreler:**

- `latitude`
- `longitude`

---



