# Guess The Footballer - WordPress Eklentisi Gereksinim Dokümanı

## 📋 Proje Özeti
WordPress tabanlı bir futbolcu tahmin oyunu. Kullanıcılar bulanık bir futbolcu fotoğrafına bakarak 5 denemede oyuncuyu tahmin etmeye çalışır.

---

## 🎯 Temel Özellikler

### Oyun Mekaniği
- **Oyun Türü**: Sınırsız rastgele futbolcular (sürekli oynanabilir)
- **Deneme Hakkı**: 5 deneme
- **Bulanıklık Efekti**: CSS blur-filter kullanılarak her yanlış denemede giderek azalır
- **Tahmin Sistemi**: Serbest text input - sadece isim yazma
- **Karakter Toleransı**: Türkçe karakter duyarsız (ı=i, ü=u, ğ=g, ş=s, ç=c, ö=o)

### Görsel Feedback Sistemi
- **Wordle Tarzı Kutular**: 5 adet dikey sıralı input kutusu (üstten aşağıya)
- **Doğru Tahmin**: Her harf yeşil renkte gösterilir
- **Yanlış Tahmin**: Kırmızı mesaj + girilen isim gösterilir
- **Blur Seviyesi**: 
  - 1. deneme: blur(20px)
  - 2. deneme: blur(15px)
  - 3. deneme: blur(10px)
  - 4. deneme: blur(5px)
  - 5. deneme: blur(0px)

### Kullanıcı Deneyimi
- **Oyun Akışı**: Kullanıcı "Yeni Oyun" butonuna tıklayana kadar aynı futbolcu gösterilir
- **Streak Sistemi**: localStorage bazlı - üst üste kaç doğru bilindi
- **Oyun Sonu Ekranı**:
  - Doğru cevap gösterilir
  - Mevcut streak sayısı
  - "Yeni Oyun" butonu

---

## 🗄️ Veritabanı Yapısı

### Custom Post Type: `footballer`
```
Post Type Name: footballer
Supports: title, thumbnail
Hierarchical: false
Public: false (sadece admin erişimi)
Show in menu: true
Menu icon: dashicons-businessman
```

### Meta Fields
- `player_name` (string, required): Futbolcu adı
- `player_photo` (attachment_id): Futbolcu fotoğrafı (WordPress Media Library)

### Admin Panel Özellikleri
- Futbolcu ekleme/düzenleme/silme
- Futbolcu listesi görüntüleme (tablo formatında)
- Fotoğraf yükleme (WordPress Media Uploader)
- Toplu işlemler (bulk actions)

---

## 🎨 Tasarım Gereksinimleri

### Genel Tasarım
- **Stil**: Modern/Minimal + Wordle tarzı
- **Responsive**: Mobile-first yaklaşım
- **Renk Şeması**: 
  - Doğru: #6aaa64 (yeşil)
  - Yanlış: #dc3545 (kırmızı)
  - Nötr: #787c7e (gri)
  - Arka plan: #ffffff (beyaz)
  - Container: #f8f9fa (açık gri)

### Layout Yapısı
```
┌─────────────────────────────┐
│    GUESS THE FOOTBALLER     │
│         (Logo/Title)        │
├─────────────────────────────┤
│                             │
│   [Blurred Image]           │
│      (300x400px)            │
│                             │
├─────────────────────────────┤
│  ┌───────────────────────┐  │
│  │   1. Tahmin [Empty]   │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │   2. Tahmin [Empty]   │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │   3. Tahmin [Empty]   │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │   4. Tahmin [Empty]   │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │   5. Tahmin [Active]  │  │
│  └───────────────────────┘  │
├─────────────────────────────┤
│    Streak: 🔥 5             │
└─────────────────────────────┘
```

---

## 💻 Teknik Gereksinimler

### Frontend
- **Teknoloji**: Vanilla JavaScript (dependency-free)
- **Stil**: CSS3 (modern features)
- **Özellikler**:
  - localStorage API (oyun durumu ve istatistikler)
  - Fetch API (AJAX requests)
  - CSS transitions ve animations
  - Mobile responsive (media queries)

### Backend
- **Platform**: WordPress 5.8+
- **PHP Version**: 7.4+
- **Template**: Özel sayfa template'i (`page-guess-footballer.php`)
- **AJAX Endpoints**:
  - `get_random_footballer` - Rastgele futbolcu getir
  - `validate_guess` - Tahmin kontrolü

### WordPress Entegrasyonu
- **Custom Post Type**: footballer
- **Page Template**: Özel template dosyası
- **Enqueue Scripts**: wp_enqueue_script/style
- **AJAX**: wp_ajax_* hooks
- **Nonce Security**: wp_nonce_field validation

---

## 📁 Dosya Yapısı

```
guess-the-footballer/
├── guess-the-footballer.php          # Ana eklenti dosyası
├── includes/
│   ├── class-footballer-cpt.php      # Custom Post Type
│   ├── class-ajax-handler.php        # AJAX işlemleri
│   └── class-game-logic.php          # Oyun mantığı
├── templates/
│   └── page-guess-footballer.php     # Sayfa template'i
├── assets/
│   ├── css/
│   │   ├── admin.css                 # Admin panel stilleri
│   │   └── frontend.css              # Oyun arayüzü stilleri
│   └── js/
│       ├── admin.js                  # Admin panel JS
│       └── game.js                   # Oyun mantığı JS
└── README.md                         # Kurulum ve kullanım
```

---

## 🎮 Oyun Akışı (Flow Chart)

```
START
  ↓
Sayfa Yüklenir
  ↓
localStorage'dan streak ve oyun durumu kontrol edilir
  ↓
Mevcut oyun var mı?
  ├─ EVET → Oyuna devam et (aynı futbolcu + blur seviyesi)
  └─ HAYIR → Yeni futbolcu getir (AJAX: get_random_footballer)
          ↓
      Futbolcu fotoğrafı blur(20px) ile gösterilir
          ↓
      Kullanıcı tahmin girer
          ↓
      Karakter normalizasyonu yapılır (ı→i, ü→u vb.)
          ↓
      Tahmin doğru mu?
          ├─ EVET → ✅ Yeşil kutular
          │         → Streak +1
          │         → Başarı mesajı
          │         → "Yeni Oyun" butonu göster
          │         → localStorage'a kaydet
          │         → END
          │
          └─ HAYIR → ❌ Kırmızı mesaj + girilen isim
                    → Blur azalt (bir sonraki seviye)
                    → Deneme sayısı +1
                    → 5. deneme bitti mi?
                        ├─ EVET → Doğru cevabı göster
                        │         → Streak = 0
                        │         → "Yeni Oyun" butonu
                        │         → END
                        └─ HAYIR → Tekrar tahmin iste
```

---

## 🔐 Güvenlik Gereksinimleri

1. **AJAX Nonce Validation**: Her AJAX isteğinde nonce kontrolü
2. **Sanitization**: Tüm kullanıcı girdileri sanitize edilmeli
3. **Capability Check**: Admin işlemleri için yetki kontrolü
4. **SQL Injection Prevention**: WordPress $wpdb prepared statements
5. **XSS Prevention**: esc_html, esc_attr kullanımı

---

## 📱 Responsive Breakpoints

```css
/* Mobile First */
Default: 320px - 767px (Mobile)
@media (min-width: 768px)  /* Tablet */
@media (min-width: 1024px) /* Desktop */
```

### Mobile Optimizasyonları
- Fotoğraf boyutu: 280x373px
- Kutu genişliği: %100
- Font boyutları: 16px (base)
- Touch-friendly butonlar: min-height 44px

---

## 🧪 Test Senaryoları (Checklist)

### Temel Fonksiyonalite
- [ ] Sayfa yüklendiğinde rastgele futbolcu getiriliyor mu?
- [ ] Blur efekti her denemede azalıyor mu?
- [ ] Türkçe karakterler doğru normalize ediliyor mu? (Messi = Messı)
- [ ] 5 deneme sonunda oyun bitiyor mu?
- [ ] Doğru tahminde yeşil kutular görünüyor mu?
- [ ] Yanlış tahminde kırmızı mesaj çıkıyor mu?

### Streak Sistemi
- [ ] Doğru tahminde streak artıyor mu?
- [ ] Yanlış tahminde streak sıfırlanıyor mu?
- [ ] Streak sayısı localStorage'a kaydediliyor mu?
- [ ] Sayfa yenilendiğinde streak korunuyor mu?

### Yeni Oyun
- [ ] "Yeni Oyun" butonu yeni futbolcu getiriyor mu?
- [ ] Blur seviyesi sıfırlanıyor mu?
- [ ] Deneme sayacı resetleniyor mu?
- [ ] Önceki kutular temizleniyor mu?

### Admin Panel
- [ ] Yeni futbolcu eklenebiliyor mu?
- [ ] Fotoğraf yüklenebiliyor mu?
- [ ] Futbolcu listesi görüntülenebiliyor mu?
- [ ] Düzenleme ve silme çalışıyor mu?

### Responsive
- [ ] Mobile'da düzgün görünüyor mu?
- [ ] Tablet'te layout bozulmuyor mu?
- [ ] Desktop'ta merkezi hizalama doğru mu?
- [ ] Touch events çalışıyor mu?

---

## 🚀 Kurulum Adımları (Özet)

1. Eklenti klasörünü `/wp-content/plugins/` dizinine yükle
2. WordPress admin panelden eklentiyi aktif et
3. "Footballers" menüsünden futbolcu ekle
4. Yeni sayfa oluştur ve "Guess Footballer Template" seç
5. Sayfayı yayınla ve test et

---

## 📊 localStorage Veri Yapısı

```javascript
{
  "gtf_current_game": {
    "footballer_id": 123,
    "footballer_name": "Lionel Messi",
    "attempts": 2,
    "guesses": ["Ronaldo", "Neymar"],
    "blur_level": 10,
    "is_completed": false
  },
  "gtf_stats": {
    "current_streak": 5,
    "total_games": 47,
    "total_wins": 42
  }
}
```

---

## 🎨 CSS Değişkenler (Standardizasyon)

```css
:root {
  /* Colors */
  --gtf-correct: #6aaa64;
  --gtf-wrong: #dc3545;
  --gtf-neutral: #787c7e;
  --gtf-bg: #ffffff;
  --gtf-container-bg: #f8f9fa;
  --gtf-border: #d3d6da;
  
  /* Spacing */
  --gtf-spacing-xs: 8px;
  --gtf-spacing-sm: 12px;
  --gtf-spacing-md: 16px;
  --gtf-spacing-lg: 24px;
  --gtf-spacing-xl: 32px;
  
  /* Typography */
  --gtf-font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  --gtf-font-size-base: 16px;
  --gtf-font-size-lg: 20px;
  --gtf-font-size-xl: 24px;
  
  /* Blur Levels */
  --gtf-blur-1: blur(20px);
  --gtf-blur-2: blur(15px);
  --gtf-blur-3: blur(10px);
  --gtf-blur-4: blur(5px);
  --gtf-blur-5: blur(0px);
  
  /* Transitions */
  --gtf-transition: all 0.3s ease;
}
```

---

## ⚡ Performans Optimizasyonları

1. **Lazy Loading**: Fotoğraflar lazy load edilmeli
2. **Image Optimization**: Fotoğraflar WebP formatında
3. **Caching**: WordPress transient API kullanımı
4. **Minification**: CSS/JS minify edilmeli
5. **CDN Ready**: Asset URL'leri CDN uyumlu

---

## 🌐 Çoklu Dil Desteği (İsteğe Bağlı)

Tüm kullanıcıya gösterilen metinler için:
```php
__('Guess The Footballer', 'guess-the-footballer')
```

---

## 📝 Notlar ve Öneriler

1. **WordPress Coding Standards** takip edilmeli
2. **Escaping fonksiyonları** her output'ta kullanılmalı
3. **Prefix kullanımı**: Tüm fonksiyon ve değişkenler `gtf_` prefix'i ile başlamalı
4. **Error Handling**: Try-catch blokları ve WordPress error handling
5. **Documentation**: Her fonksiyon DocBlock ile dokümante edilmeli
6. **Version Control**: Git kullanımı önerilir
7. **Backup**: Veritabanı ve dosya yedekleri düzenli alınmalı

---

## 🔄 Gelecek Versiyon İçin Fikirler

- Zorluk seviyeleri (kolay/orta/zor)
- Günlük challenge modu
- Sosyal medya paylaşım
- Liderlik tablosu
- İstatistik detayları (ortalama deneme sayısı)
- Kategori bazlı oyun (liga, pozisyon, ülke)
- Multiplayer modu
- API entegrasyonu (otomatik futbolcu veritabanı)

---

**Versiyon**: 1.0.0  
**Son Güncelleme**: 2024  
**Yazar**: [Projenizi Geliştirecek Kişi/Ekip]
