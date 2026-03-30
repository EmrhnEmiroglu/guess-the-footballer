# 🤖 Guess The Footballer - AI Geliştirme Prompt'u

Bu prompt'u bir AI asistanına (ChatGPT, Claude, vb.) vererek WordPress eklentisini geliştirebilirsiniz.

---

## 📋 Ana Prompt

```
WordPress için "Guess The Footballer" adında bir eklenti geliştirmeni istiyorum. 

Bu eklenti, kullanıcıların bulanık bir futbolcu fotoğrafına bakarak 5 denemede oyuncuyu tahmin etmeye çalıştığı bir oyundur.

## Temel Gereksinimler:

### 1. Custom Post Type
- Post type name: `footballer`
- Meta fields:
  - `player_name` (string, zorunlu)
  - `player_photo` (attachment_id)
- Admin panelinde futbolcu ekleme/düzenleme/listeleme özellikleri

### 2. Page Template
- Template dosyası: `page-guess-footballer.php`
- Özel sayfa template'i olarak çalışmalı
- Modern ve responsive tasarım

### 3. Oyun Mekaniği
- 5 deneme hakkı
- Her yanlış denemede blur efekti azalır (blur-filter: 20px → 15px → 10px → 5px → 0px)
- Wordle tarzı kutular: 5 adet dikey sıralı input (üstten aşağıya)
- Doğru tahminde her harf yeşil (#6aaa64)
- Yanlış tahminde kırmızı mesaj (#dc3545) + girilen isim gösterilir
- Türkçe karakter toleransı: ı=i, ü=u, ğ=g, ş=s, ç=c, ö=o

### 4. Oyun Akışı
- Kullanıcı "Yeni Oyun" butonuna tıklayana kadar aynı futbolcu gösterilir
- Rastgele futbolcu seçimi (AJAX ile)
- localStorage bazlı streak sistemi (üst üste kaç doğru)
- Oyun bitiminde: doğru cevap + mevcut streak + "Yeni Oyun" butonu

### 5. Teknik Detaylar
- Frontend: Vanilla JavaScript (dependency-free)
- localStorage kullanımı (oyun durumu ve istatistikler)
- AJAX endpoints:
  - `get_random_footballer` - Rastgele futbolcu getir
  - `validate_guess` - Tahmin kontrolü
- Nonce security validation
- Mobile-first responsive design

### 6. Dosya Yapısı
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
│   │   ├── admin.css                 # Admin stilleri
│   │   └── frontend.css              # Oyun stilleri
│   └── js/
│       ├── admin.js                  # Admin JS
│       └── game.js                   # Oyun JS
└── README.md
```

### 7. localStorage Veri Yapısı
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

### 8. Önemli Kurallar
- WordPress Coding Standards takip et
- Tüm değişken ve fonksiyonlar `gtf_` prefix'i ile başlamalı
- Escaping fonksiyonları kullan (esc_html, esc_attr)
- Nonce validation her AJAX isteğinde
- Mobile responsive (320px'den başlayarak)
- Modern/minimal + Wordle tarzı tasarım

Lütfen tam çalışır bir WordPress eklentisi oluştur. Her dosyayı ayrı ayrı göster ve detaylı açıklamalar ekle.
```

---

## 🎯 Adım Adım Geliştirme Prompt'ları

Eğer AI'ya adım adım ilerlemek istersen, aşağıdaki prompt'ları sırayla kullanabilirsin:

### Adım 1: Ana Eklenti Dosyası
```
WordPress eklentisi için ana dosyayı (guess-the-footballer.php) oluştur. 
Bu dosya:
- Eklenti header bilgilerini içermeli
- Custom Post Type, AJAX handler ve Game Logic class'larını include etmeli
- Activation/deactivation hook'ları tanımlamalı
- Assets'leri enqueue etmeli
```

### Adım 2: Custom Post Type
```
includes/class-footballer-cpt.php dosyasını oluştur.
Bu class:
- 'footballer' custom post type'ını register etmeli
- Meta box'ları (player_name, player_photo) eklemeli
- Admin panelinde futbolcu listesi için custom columns oluşturmalı
- Media uploader entegrasyonu yapmalı
```

### Adım 3: AJAX Handler
```
includes/class-ajax-handler.php dosyasını oluştur.
İki AJAX endpoint:
1. get_random_footballer: Rastgele bir futbolcu getir (ID, name, photo URL)
2. validate_guess: Kullanıcı tahminini kontrol et (Türkçe karakter normalizasyonu ile)
Her endpoint nonce validation yapmalı.
```

### Adım 4: Game Logic
```
includes/class-game-logic.php dosyasını oluştur.
Bu class:
- Rastgele futbolcu seçme fonksiyonu
- Tahmin normalizasyonu (ı→i, ü→u dönüşümleri)
- Blur seviyesi hesaplama
- String karşılaştırma (case-insensitive, karakter toleranslı)
```

### Adım 5: Page Template
```
templates/page-guess-footballer.php dosyasını oluştur.
Template şunları içermeli:
- WordPress header/footer
- Oyun container yapısı
- Blurred image container
- 5 adet tahmin input kutusu (Wordle style)
- Streak göstergesi
- "Yeni Oyun" butonu
- Sonuç mesajları için placeholder'lar
```

### Adım 6: Frontend JavaScript
```
assets/js/game.js dosyasını oluştur.
Bu dosya:
- localStorage yönetimi
- AJAX çağrıları
- Blur seviyesi güncelleme
- Input validasyonu
- Wordle-style kutu animasyonları
- Oyun durumu takibi
- Streak hesaplama
Vanilla JavaScript kullan, jQuery veya framework kullanma.
```

### Adım 7: Frontend CSS
```
assets/css/frontend.css dosyasını oluştur.
Modern, minimal ve Wordle tarzı tasarım:
- Mobile-first responsive
- CSS Grid/Flexbox layout
- Smooth transitions
- Renk şeması: yeşil (#6aaa64), kırmızı (#dc3545), nötr (#787c7e)
- Blur filter animasyonları
```

### Adım 8: Admin Stilleri
```
assets/css/admin.css ve assets/js/admin.js dosyalarını oluştur.
Admin panel için:
- Futbolcu listesi tablosu stilleri
- Media uploader entegrasyonu
- Form stilleri
- Responsive admin panel
```

---

## 🔧 Debugging ve Test Prompt'ları

### Hata Ayıklama
```
Guess The Footballer eklentisinde şu sorunu yaşıyorum: [SORUN AÇIKLAMASI]
Lütfen şunları kontrol et:
1. AJAX endpoint'leri doğru kayıtlı mı?
2. Nonce validation çalışıyor mu?
3. localStorage doğru güncelleniyor mu?
4. Console'da JavaScript hatası var mı?
Hatayı bul ve düzeltilmiş kodu ver.
```

### Performans Optimizasyonu
```
Guess The Footballer eklentisinin performansını optimize et:
1. Image lazy loading ekle
2. CSS/JS minify et
3. WordPress transient API ile caching ekle
4. Gereksiz database query'lerini azalt
```

### Yeni Özellik Ekleme
```
Guess The Footballer eklentisine [ÖZELLİK] ekle.
Mevcut kod yapısını bozmadan, aynı coding standards'ı takip ederek ekle.
Değişen dosyaları ve yeni fonksiyonları açıkla.
```

---

## 📚 Referans Kod Snippet'leri

Bu snippet'leri AI'ya bağlam olarak verebilirsin:

### Türkçe Karakter Normalizasyonu
```php
function gtf_normalize_string($string) {
    $string = mb_strtolower($string, 'UTF-8');
    $replacements = array(
        'ı' => 'i', 'İ' => 'i',
        'ğ' => 'g', 'Ğ' => 'g',
        'ü' => 'u', 'Ü' => 'u',
        'ş' => 's', 'Ş' => 's',
        'ö' => 'o', 'Ö' => 'o',
        'ç' => 'c', 'Ç' => 'c'
    );
    return strtr($string, $replacements);
}
```

### localStorage Yönetimi (JavaScript)
```javascript
const GTF_Storage = {
    get(key) {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    },
    set(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    },
    remove(key) {
        localStorage.removeItem(key);
    }
};
```

### Blur Seviyesi Hesaplama
```javascript
function calculateBlurLevel(attempts) {
    const blurLevels = [20, 15, 10, 5, 0];
    return blurLevels[Math.min(attempts, 4)];
}
```

---

## 🎨 Tasarım Referansları

AI'ya bu tasarım örneklerini gösterebilirsin:

```
Wordle benzeri kutu tasarımı için:
- Her kutu: 60px height, border-radius: 4px
- Empty state: border 2px solid #d3d6da
- Correct state: background #6aaa64, color white
- Wrong state: border 2px solid #dc3545
- Typing animation: scale transform
```

```
Responsive breakpoints:
Mobile: 320px - 767px
  - Image: 280x373px
  - Font: 16px
  - Padding: 16px

Tablet: 768px - 1023px
  - Image: 300x400px
  - Font: 18px
  - Padding: 24px

Desktop: 1024px+
  - Image: 350x467px
  - Font: 20px
  - Padding: 32px
```

---

## 🚨 Yaygın Hatalar ve Çözümleri

AI'ya bu hataları önlemesi için uyarı ver:

### Hata 1: AJAX 400 Bad Request
```
Çözüm: wp_ajax_* hook'ları doğru register edilmeli:
add_action('wp_ajax_get_random_footballer', 'callback');
add_action('wp_ajax_nopriv_get_random_footballer', 'callback');
```

### Hata 2: Template Görünmüyor
```
Çözüm: Template dosyası plugin klasöründe templates/ altında olmalı
ve get_template_part ile doğru çağrılmalı.
```

### Hata 3: localStorage Çalışmıyor
```
Çözüm: Browser compatibility check ekle:
if (typeof(Storage) !== "undefined") {
    // localStorage kullan
} else {
    // Fallback: cookie veya session
}
```

### Hata 4: Blur Efekti Çalışmıyor
```
Çözüm: CSS filter property'si ve inline style:
<img style="filter: blur(20px); transition: filter 0.3s ease;">
```

---

## 📦 Kurulum Sonrası Test Prompt'u

```
Guess The Footballer eklentisini test et ve şu senaryoları kontrol et:

1. Yeni futbolcu ekle:
   - Admin panelde "Add New Footballer" tıkla
   - İsim gir: "Cristiano Ronaldo"
   - Fotoğraf yükle
   - Publish et

2. Sayfa oluştur:
   - Pages → Add New
   - Template: "Guess Footballer Template" seç
   - Publish ve sayfayı görüntüle

3. Oyun testi:
   - Sayfayı aç
   - Bulanık fotoğraf görünüyor mu?
   - "messi" yaz (yanlış tahmin)
   - Blur azaldı mı?
   - Kırmızı mesaj çıktı mı?
   - 5 deneme sonunda oyun bitiyor mu?

4. Streak testi:
   - Doğru tahmin yap
   - Streak arttı mı?
   - Sayfayı yenile
   - Streak korunuyor mu?

Her test için pass/fail durumunu raporla.
```

---

## 🎓 Ek Özellikler için Prompt'lar

### Zorluk Seviyeleri Ekleme
```
Guess The Footballer eklentisine 3 zorluk seviyesi ekle:
- Kolay: 7 deneme, blur başlangıç 15px
- Orta: 5 deneme, blur başlangıç 20px (mevcut)
- Zor: 3 deneme, blur başlangıç 25px

Admin panelden varsayılan zorluk seçilebilmeli.
Kullanıcı oyun başında zorluk seçebilmeli.
```

### Liderlik Tablosu
```
Kullanıcı kaydı olmadan çalışan bir liderlik tablosu ekle:
- Kullanıcı nickname girer
- localStorage'da saklanır
- En yüksek streak'ler listelenir (top 10)
- JSON dosyasında veya WordPress transient'ta tutulur
```

### Sosyal Medya Paylaşım
```
Oyun bitiminde paylaşım butonu ekle:
- Twitter, Facebook, WhatsApp
- Paylaşım metni: "Guess The Footballer'da [FUTBOLCU] 3/5 denemede buldum! 🔥 Streak: 8"
- Wordle tarzı emoji grid (🟩⬜⬜⬜⬜)
```

---

## 💡 Önemli Notlar

1. **WordPress Version**: Minimum WP 5.8+ gerektiğini belirt
2. **PHP Version**: Minimum PHP 7.4+ gerektiğini belirt
3. **Browser Support**: Modern browsers (Chrome, Firefox, Safari, Edge)
4. **Mobile Testing**: iOS Safari ve Android Chrome'da test et
5. **Security**: Nonce, sanitization, escaping'i unutma
6. **Performance**: Image optimization ve lazy loading önemli
7. **Accessibility**: ARIA labels ve keyboard navigation ekle
8. **Documentation**: Inline comments ve DocBlock kullan

---

## 🔗 Yararlı Linkler

AI'ya bu linkleri referans olarak verebilirsin:

- WordPress Plugin Handbook: https://developer.wordpress.org/plugins/
- WordPress Coding Standards: https://developer.wordpress.org/coding-standards/
- Custom Post Types: https://developer.wordpress.org/plugins/post-types/
- AJAX in WordPress: https://developer.wordpress.org/plugins/javascript/ajax/
- Enqueuing Scripts: https://developer.wordpress.org/reference/functions/wp_enqueue_script/

---

**Kullanım**: Bu prompt'u AI asistanına yapıştır ve "Başla" de. AI, tüm dosyaları sırayla oluşturacaktır.

**İpucu**: Eğer AI'nın yanıtı kesilirse, "Devam et" yazarak kaldığı yerden devam etmesini sağlayabilirsin.
