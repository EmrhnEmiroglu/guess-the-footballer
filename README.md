# Guess The Footballer

WordPress plugin - bulanık futbolcu fotoğrafından 5 denemede tahmin oyunu (Wordle benzeri).

## Özellikler
- 5 deneme hakkı
- Bulanık görsel efekti (her yanlışta azalır)
- Streak sistemi (localStorage)
- Responsive tasarım

## Gereksinimler
- WordPress 5.8+
- PHP 7.4+

## Kurulum
1. Eklentiyi `/wp-content/plugins/guess-the-footballer/` dizinine yükle
2. WordPress admin panelden aktif et
3. **Footballers** menüsünden futbolcu ekle (isim + fotoğraf)
4. Yeni sayfa oluştur ve **"Guess Footballer Template"** seç

## Kullanım
1. **Footballers** menüsünden birkaç futbolcu ekle
2. Sayfayı görüntüle ve oyunu başlat
3. 5 deneme içinde futbolcuyu tahmin et

## AJAX Endpoint'leri
- `get_random_footballer`
- `validate_guess`

## Test Kontrol Listesi (Özet)
- [ ] Rastgele futbolcu ve fotoğraf yükleniyor mu?
- [ ] Blur seviyesi her yanlışta azalıyor mu?
- [ ] Türkçe karakterler doğru normalize ediliyor mu? (ı=i, ü=u vb.)
- [ ] Doğru tahminde yeşil kutular görünüyor mu?
- [ ] 5 deneme sonunda oyun bitiyor mu?
- [ ] Streak değeri yenilemede korunuyor mu?

## Versiyon
v0.1.0

## Lisans
GPL v2 or later