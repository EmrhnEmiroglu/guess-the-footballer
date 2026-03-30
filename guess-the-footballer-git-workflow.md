# 🔄 Guess The Footballer - Git & GitHub Workflow Guide

Bu doküman, projenin Git ile sağlıklı versiyon kontrolü ve GitHub entegrasyonu için tam bir rehberdir.

---

## 📋 İçindekiler

1. [İlk Kurulum ve Repository Oluşturma](#1-ilk-kurulum)
2. [Branch Stratejisi](#2-branch-stratejisi)
3. [Commit Standartları](#3-commit-standartlari)
4. [AI ile Geliştirme Workflow'u](#4-ai-ile-gelistirme-workflow)
5. [Geri Dönüş Senaryoları](#5-geri-donus-senaryolari)
6. [GitHub Issues ve Project Board](#6-github-issues)
7. [Release Management](#7-release-management)

---

## 1. İlk Kurulum ve Repository Oluşturma {#1-ilk-kurulum}

### Adım 1.1: GitHub Repository Oluştur

**GitHub'da:**
```
1. GitHub'a giriş yap
2. Repositories → New
3. Repository name: guess-the-footballer
4. Description: WordPress plugin - Guess footballer from blurred image (Wordle-style game)
5. Public veya Private seç
6. ✅ Add README file
7. ✅ Add .gitignore (WordPress seç)
8. ✅ Choose a license (GPL v2 or later - WordPress uyumlu)
9. Create repository
```

### Adım 1.2: Local Proje Klasörünü Oluştur

```bash
# WordPress plugins klasörüne git
cd /path/to/wordpress/wp-content/plugins/

# Repository'yi clone'la
git clone https://github.com/[USERNAME]/guess-the-footballer.git

# Klasöre gir
cd guess-the-footballer

# Mevcut durumu kontrol et
git status
```

### Adım 1.3: İlk Proje Yapısını Oluştur

```bash
# Klasör yapısını oluştur
mkdir -p includes templates assets/css assets/js

# Placeholder dosyaları oluştur
touch guess-the-footballer.php
touch includes/.gitkeep
touch templates/.gitkeep
touch assets/css/.gitkeep
touch assets/js/.gitkeep

# README güncelle
cat > README.md << 'EOF'
# Guess The Footballer

WordPress plugin - Futbolcu tahmin oyunu (Wordle benzeri)

## Özellikler
- 5 deneme hakkı
- Bulanık görsel efekti
- Streak sistemi (localStorage)
- Responsive tasarım

## Kurulum
1. Eklentiyi `/wp-content/plugins/guess-the-footballer/` dizinine yükle
2. WordPress admin panelden aktif et
3. Footballers menüsünden futbolcu ekle
4. Yeni sayfa oluştur ve "Guess Footballer Template" seç

## Versiyon
v0.1.0 - Initial setup

## Lisans
GPL v2 or later
EOF

# Tüm değişiklikleri stage'e al
git add .

# İlk commit
git commit -m "chore: initial project structure"

# GitHub'a push et
git push origin main
```

---

## 2. Branch Stratejisi {#2-branch-stratejisi}

### Branch Yapısı

```
main (production-ready)
  ↓
develop (development branch)
  ↓
feature/* (yeni özellikler)
bugfix/* (hata düzeltmeleri)
hotfix/* (acil düzeltmeler)
```

### Branch Oluşturma Kuralları

```bash
# Development branch oluştur (ilk kez)
git checkout -b develop
git push -u origin develop

# Feature branch (yeni özellik için)
git checkout develop
git checkout -b feature/custom-post-type
# Geliştir...
git push -u origin feature/custom-post-type

# Bugfix branch (hata düzeltme için)
git checkout develop
git checkout -b bugfix/blur-effect-not-working
# Düzelt...
git push -u origin bugfix/blur-effect-not-working

# Hotfix branch (acil düzeltme için)
git checkout main
git checkout -b hotfix/security-patch
# Düzelt...
git push -u origin hotfix/security-patch
```

### Branch İsimlendirme Örnekleri

```
✅ İYİ ÖRNEKLER:
- feature/ajax-handler
- feature/admin-panel
- feature/streak-system
- bugfix/turkish-character-normalization
- bugfix/localStorage-not-persisting
- hotfix/sql-injection-vulnerability

❌ KÖTÜ ÖRNEKLER:
- fix
- test
- deneme
- feature1
- yeni-ozellik
```

---

## 3. Commit Standartları {#3-commit-standartlari}

### Conventional Commits Formatı

```
<type>(<scope>): <subject>

<body> (opsiyonel)

<footer> (opsiyonel)
```

### Type'lar

```
feat:     Yeni özellik
fix:      Hata düzeltme
docs:     Dokümantasyon
style:    Kod formatı (logic değişmez)
refactor: Kod iyileştirme (yeni özellik veya fix değil)
test:     Test ekleme/düzeltme
chore:    Build, config, vb. (kaynak kodu etkilemez)
perf:     Performance iyileştirmesi
```

### Commit Örnekleri

```bash
# Feature
git commit -m "feat(cpt): add footballer custom post type"
git commit -m "feat(ajax): implement random footballer endpoint"
git commit -m "feat(ui): add wordle-style input boxes"

# Fix
git commit -m "fix(normalize): handle turkish characters correctly"
git commit -m "fix(blur): blur level not decreasing after attempts"
git commit -m "fix(localStorage): streak not persisting on page reload"

# Docs
git commit -m "docs(readme): add installation instructions"
git commit -m "docs(api): document AJAX endpoints"

# Style
git commit -m "style(css): format code with prettier"
git commit -m "style(php): fix indentation in class-ajax-handler.php"

# Refactor
git commit -m "refactor(game-logic): extract normalization to separate method"
git commit -m "refactor(js): simplify localStorage management"

# Chore
git commit -m "chore(deps): update WordPress tested version to 6.4"
git commit -m "chore(gitignore): add node_modules"

# Çok satırlı commit
git commit -m "feat(streak): implement streak system

- Add localStorage management
- Display current streak on UI
- Reset streak on wrong guess
- Persist streak across sessions

Closes #12"
```

### Commit Mesajı Kuralları

```
✅ İYİ:
- feat(cpt): add footballer custom post type
- fix(blur): resolve blur calculation bug
- docs: update README with new features

❌ KÖTÜ:
- update
- fix bug
- değişiklikler
- asdasd
- test commit
```

---

## 4. AI ile Geliştirme Workflow'u {#4-ai-ile-gelistirme-workflow}

### 4.1 Özellik Geliştirme Döngüsü

```bash
# 1. ÖNCE: Develop branch'ten yeni feature branch oluştur
git checkout develop
git pull origin develop
git checkout -b feature/ajax-handler

# 2. AI'ya prompt ver (örnek prompt aşağıda)

# 3. AI'dan gelen kodu dosyalara kaydet

# 4. Test et

# 5. Çalışıyorsa commit et
git add includes/class-ajax-handler.php
git commit -m "feat(ajax): implement get_random_footballer endpoint"

# 6. Başka değişiklik varsa tekrar commit
git add includes/class-ajax-handler.php
git commit -m "feat(ajax): add validate_guess endpoint with nonce security"

# 7. GitHub'a push et
git push -u origin feature/ajax-handler

# 8. Pull Request oluştur (GitHub'da)
# develop ← feature/ajax-handler

# 9. Merge et ve branch'i sil
git checkout develop
git pull origin develop
git branch -d feature/ajax-handler
git push origin --delete feature/ajax-handler
```

### 4.2 AI için Git-Aware Prompt Şablonu

```markdown
### AI Prompt Şablonu:

Ben "Guess The Footballer" WordPress eklentisi geliştiriyorum.

**Mevcut Branch**: feature/ajax-handler
**Mevcut Durum**: Custom Post Type hazır, şimdi AJAX handler geliştireceğiz.

**İstenen Özellik**:
includes/class-ajax-handler.php dosyasını oluştur.

Bu class şunları yapmalı:
1. get_random_footballer endpoint'i (rastgele futbolcu getir)
2. validate_guess endpoint'i (tahmin kontrolü)
3. Nonce validation
4. Türkçe karakter normalizasyonu ile string karşılaştırma

**Git Commit Stratejisi**:
- Her major özellik için ayrı commit atacağım
- Conventional commits kullanıyorum
- Bu dosya için 1-2 commit yeterli

Lütfen:
1. Tam çalışır kodu ver
2. Hangi commit mesajlarını kullanmam gerektiğini öner
3. Test için örnek kullanım göster

**Dosya Yolu**: `includes/class-ajax-handler.php`
```

### 4.3 AI'ya Versiyon Kontrolü için Özel Talimatlar

AI'ya her geliştirme adımında şunu söyle:

```
Kodu verirken şunları da ekle:
1. Bu değişiklik için uygun git commit mesajı (conventional commits formatında)
2. Eğer birden fazla commit gerekiyorsa, hangi değişikliklerin hangi commit'e girmesi gerektiğini belirt
3. Branch stratejisi önerisi (feature/bugfix/hotfix)

Örnek format:
```
# Dosya: includes/class-ajax-handler.php
[KOD]

## Git İşlemleri:
# Commit 1:
git add includes/class-ajax-handler.php
git commit -m "feat(ajax): add get_random_footballer endpoint"

# Commit 2:
git add includes/class-ajax-handler.php
git commit -m "feat(ajax): add validate_guess with nonce validation"
```
```

---

## 5. Geri Dönüş Senaryoları {#5-geri-donus-senaryolari}

### 5.1 Son Commit'i Geri Al

```bash
# Henüz push edilmemiş son commit'i geri al (değişiklikler kalır)
git reset --soft HEAD~1

# Henüz push edilmemiş son commit'i geri al (değişiklikler de silinir)
git reset --hard HEAD~1

# Push edilmiş commit'i geri al (yeni commit oluşturur)
git revert HEAD
git push origin feature/ajax-handler
```

### 5.2 Belirli Bir Commit'e Geri Dön

```bash
# Commit geçmişini görüntüle
git log --oneline

# Çıktı örneği:
# a1b2c3d feat(ajax): add validate_guess endpoint
# e4f5g6h feat(ajax): add get_random_footballer endpoint
# i7j8k9l feat(cpt): add footballer custom post type

# Belirli commit'e geri dön (değişiklikler kalır)
git reset --soft e4f5g6h

# Belirli commit'e geri dön (değişiklikler silinir)
git reset --hard e4f5g6h

# UYARI: Push edilmiş commit'lerde --hard kullanma!
# Bunun yerine revert kullan:
git revert a1b2c3d
```

### 5.3 Belirli Dosyayı Önceki Haline Getir

```bash
# Belirli dosyayı belirli commit'ten getir
git log --oneline -- includes/class-ajax-handler.php
git checkout e4f5g6h -- includes/class-ajax-handler.php

# Belirli dosyayı son commit'ten getir (çalışma dizinindeki değişiklikleri iptal et)
git checkout -- includes/class-ajax-handler.php

# Belirli dosyayı staging'den çıkar (unstage)
git reset HEAD includes/class-ajax-handler.php
```

### 5.4 Branch Arası Geçiş ve Koruma

```bash
# Değişiklikleri kaydetmeden branch değiştir (stash kullan)
git stash save "ajax handler yarı kalmış çalışma"
git checkout develop
# ... başka işler yap ...
git checkout feature/ajax-handler
git stash pop

# Stash listesini gör
git stash list

# Belirli stash'i uygula
git stash apply stash@{0}

# Stash'i sil
git stash drop stash@{0}
```

### 5.5 Merge Conflict Çözümü

```bash
# Conflict olduğunda
git status  # Conflicted dosyaları görüntüle

# Dosyayı aç ve conflict'leri düzelt:
# <<<<<<< HEAD
# Mevcut branch'teki kod
# =======
# Merge edilecek branch'teki kod
# >>>>>>> feature/ajax-handler

# Conflict'i çözdükten sonra:
git add includes/class-ajax-handler.php
git commit -m "merge: resolve conflict in ajax-handler"
```

### 5.6 Yanlış Branch'te Commit Yaptım

```bash
# Senaryo: develop'te commit yaptın ama feature branch'te olmalıydı

# 1. Yeni branch oluştur (commit'leri taşı)
git branch feature/forgot-branch

# 2. develop'i temizle
git reset --hard origin/develop

# 3. Yeni branch'e geç
git checkout feature/forgot-branch

# 4. Artık commit'ler doğru branch'te
git push -u origin feature/forgot-branch
```

### 5.7 Push Ettim, Geri Almam Lazım

```bash
# ÇÖZÜM 1: Revert (önerilen - güvenli)
git revert HEAD
git push origin feature/ajax-handler

# ÇÖZÜM 2: Force push (TEHLİKELİ - tek başına çalışıyorsan)
git reset --hard HEAD~1
git push --force origin feature/ajax-handler

# ⚠️ UYARI: Force push sadece kendi branch'lerinde ve tek çalışıyorsan kullan!
```

---

## 6. GitHub Issues ve Project Board {#6-github-issues}

### 6.1 Issue Template'leri

**GitHub'da ayarla:**
```
Settings → Features → Issues → Set up templates
```

#### Feature Request Template
```markdown
---
name: Feature Request
about: Yeni özellik önerisi
title: '[FEATURE] '
labels: enhancement
---

## Özellik Açıklaması
Eklemek istediğin özelliği açıkla.

## Kullanım Senaryosu
Bu özellik ne zaman kullanılacak?

## Teknik Detaylar
- Dosyalar: 
- Değişiklik gereken class'lar:
- Yeni bağımlılıklar:

## Öncelik
- [ ] Yüksek
- [ ] Orta
- [ ] Düşük
```

#### Bug Report Template
```markdown
---
name: Bug Report
about: Hata bildirimi
title: '[BUG] '
labels: bug
---

## Hata Açıklaması
Hatayı kısa ve net açıkla.

## Yeniden Oluşturma Adımları
1. Git '...'
2. Tıkla '....'
3. Kaydır '....'
4. Hatayı gör

## Beklenen Davranış
Ne olması gerekiyordu?

## Ekran Görüntüleri
Varsa ekle.

## Ortam
- WordPress Version:
- PHP Version:
- Browser:

## Ek Bilgi
Console hataları, log'lar vb.
```

### 6.2 Issue Kullanımı

```bash
# Issue oluştur (GitHub web interface)
1. Issues → New issue
2. Template seç
3. Detayları doldur
4. Labels ekle: bug, enhancement, documentation, etc.
5. Milestone ata (v0.1.0, v0.2.0)
6. Assignee ata (kendine)
7. Create issue

# Commit'te issue'ya referans ver
git commit -m "feat(ajax): implement random footballer endpoint

Implements #12"

# Issue'yu commit ile kapat
git commit -m "fix(blur): resolve blur calculation bug

Fixes #15"
```

### 6.3 Project Board Kurulumu

```
Projects → New project → Board
```

**Kolonlar:**
```
📋 Backlog (Yapılacaklar)
🚀 Todo (Bu sprint'te yapılacak)
👨‍💻 In Progress (Geliştiriliyor)
✅ Done (Tamamlandı)
```

**Kullanım:**
```
1. Her özellik için issue oluştur
2. Issue'ları project board'a ekle
3. Geliştirmeye başladığında "In Progress"e taşı
4. Branch oluştur: feature/#12-ajax-handler
5. Commit'lerde #12 referans et
6. PR oluştur
7. Merge edince otomatik "Done"a taşınır
```

---

## 7. Release Management {#7-release-management}

### 7.1 Versiyonlama (Semantic Versioning)

```
MAJOR.MINOR.PATCH

Örnek: 1.2.3
- MAJOR (1): Breaking changes (geriye dönük uyumsuz)
- MINOR (2): Yeni özellikler (geriye dönük uyumlu)
- PATCH (3): Bug fix'ler

Proje İçin:
v0.1.0 - İlk prototip
v0.2.0 - Custom Post Type + Admin Panel
v0.3.0 - AJAX Handler + Game Logic
v0.4.0 - Frontend UI + JavaScript
v0.5.0 - Streak System + localStorage
v1.0.0 - İlk stabil release (production-ready)
```

### 7.2 Release Branch Oluşturma

```bash
# develop'ten release branch oluştur
git checkout develop
git pull origin develop
git checkout -b release/v0.5.0

# Son düzeltmeleri yap (bug fix, version number güncelleme)
# guess-the-footballer.php dosyasında version güncelle:
# Version: 0.5.0

# Commit
git add guess-the-footballer.php
git commit -m "chore(release): bump version to 0.5.0"

# main'e merge et
git checkout main
git merge --no-ff release/v0.5.0
git tag -a v0.5.0 -m "Release version 0.5.0 - Streak system implemented"
git push origin main --tags

# develop'e de merge et
git checkout develop
git merge --no-ff release/v0.5.0
git push origin develop

# Release branch'i sil
git branch -d release/v0.5.0
```

### 7.3 GitHub Release Oluşturma

```
1. GitHub → Releases → Create a new release
2. Choose a tag: v0.5.0
3. Release title: v0.5.0 - Streak System
4. Description:
```markdown
## 🎉 v0.5.0 - Streak System

### ✨ Yeni Özellikler
- Streak sistemi eklendi (üst üste doğru tahmin)
- localStorage ile oturum persistency
- Oyun bitiminde streak gösterimi

### 🐛 Düzeltmeler
- Türkçe karakter normalizasyonu hatası düzeltildi
- Blur efekti smooth transition eklendi

### 📝 Değişiklikler
- Admin panel UI iyileştirmeleri
- Mobile responsive optimizasyonlar

### 🔧 Teknik
- PHP 7.4+ gereksinimi
- WordPress 5.8+ gereksinimi

### 📦 Kurulum
[ZIP dosyasını indir](link) ve WordPress'e yükle.

### 📚 Dokümantasyon
[Wiki](link) | [Issues](link) | [Changelog](CHANGELOG.md)
```
5. Attach binaries: ZIP dosyası ekle
6. Publish release
```

### 7.4 CHANGELOG.md Oluşturma

```bash
# Proje kök dizininde
touch CHANGELOG.md
```

```markdown
# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]
### Added
- Dark mode desteği (planlanıyor)

## [0.5.0] - 2024-12-XX
### Added
- Streak sistemi (localStorage)
- Oyun bitiminde istatistik gösterimi
- Mobile-first responsive tasarım

### Fixed
- Türkçe karakter normalizasyonu (ı=i, ü=u)
- Blur efekti transition sorunu

### Changed
- Admin panel UI refresh
- Performance optimizasyonları

## [0.4.0] - 2024-12-XX
### Added
- Frontend game UI (Wordle-style)
- JavaScript game logic
- AJAX endpoints integration

## [0.3.0] - 2024-12-XX
### Added
- AJAX handler class
- Game logic class
- Nonce security implementation

## [0.2.0] - 2024-12-XX
### Added
- Custom Post Type (footballer)
- Admin panel for footballer management
- Media uploader integration

## [0.1.0] - 2024-12-XX
### Added
- Initial project structure
- Basic plugin setup
- README and documentation

[Unreleased]: https://github.com/username/guess-the-footballer/compare/v0.5.0...HEAD
[0.5.0]: https://github.com/username/guess-the-footballer/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/username/guess-the-footballer/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/username/guess-the-footballer/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/username/guess-the-footballer/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/username/guess-the-footballer/releases/tag/v0.1.0
```

---

## 🎯 Hızlı Komut Referansı

### Günlük Kullanım

```bash
# Güncel durumu kontrol et
git status

# Değişiklikleri görüntüle
git diff

# Branch listesi
git branch -a

# Commit geçmişi
git log --oneline --graph --all

# Uzak repo bilgisi
git remote -v

# Güncel kodu çek
git pull origin develop

# Branch değiştir
git checkout develop

# Yeni branch oluştur ve geç
git checkout -b feature/new-feature

# Değişiklikleri stage'e al
git add .
# veya
git add includes/class-ajax-handler.php

# Commit
git commit -m "feat(ajax): add new endpoint"

# Push
git push origin feature/new-feature

# Merge (feature → develop)
git checkout develop
git merge feature/new-feature

# Branch sil (local)
git branch -d feature/new-feature

# Branch sil (remote)
git push origin --delete feature/new-feature
```

### Acil Durum Komutları

```bash
# Tüm değişiklikleri iptal et (tehlikeli!)
git reset --hard HEAD

# Son commit'i geri al (değişiklikler kalır)
git reset --soft HEAD~1

# Değişiklikleri geçici sakla
git stash

# Stash'i geri getir
git stash pop

# Belirli dosyayı son commit'ten getir
git checkout HEAD -- dosya.php

# Yanlış commit mesajını düzelt (henüz push edilmemişse)
git commit --amend -m "Yeni commit mesajı"
```

---

## 📚 AI'ya Verilecek Git Context Prompt

Her AI geliştirme oturumu başında bunu kullan:

```markdown
### Git Context:

**Proje**: Guess The Footballer WordPress Plugin
**Repository**: https://github.com/[USERNAME]/guess-the-footballer
**Mevcut Branch**: [BRANCH ADI]
**Son Commit**: [SON COMMIT MESAJI]

**Git Workflow Kurallarım**:
1. Conventional commits kullanıyorum (feat/fix/docs/style/refactor/test/chore)
2. Feature'lar için feature/* branch'leri oluşturuyorum
3. Her özellik tamamlandığında develop'e merge ediyorum
4. Commit'ler küçük ve spesifik olmalı (atomic commits)

**Şu an yapmak istediğim**: [YAPILACAK İŞ]

Lütfen:
- Kodu verirken uygun git commit mesajlarını da öner
- Eğer birden fazla dosya değişiyorsa, mantıksal gruplara göre commit stratejisi öner
- Branch adını öner (eğer yeni özellikse)
- Merge öncesi test edilmesi gereken noktaları belirt
```

---

## 🔗 Faydalı Git Alias'ları

`.gitconfig` dosyana ekle:

```bash
[alias]
    st = status
    co = checkout
    br = branch
    cm = commit -m
    ps = push
    pl = pull
    lg = log --oneline --graph --all --decorate
    unstage = reset HEAD --
    last = log -1 HEAD
    visual = log --oneline --graph --all --decorate --abbrev-commit
```

Kullanım:
```bash
git st           # git status
git co develop   # git checkout develop
git cm "feat: add feature"  # git commit -m "feat: add feature"
git lg           # güzel log görünümü
```

---

## ✅ Workflow Checklist

Her feature geliştirmede bu checklist'i takip et:

```
[ ] 1. Issue oluştur (#XX)
[ ] 2. develop branch'ten feature branch oluştur
[ ] 3. Branch'e geç
[ ] 4. AI'ya prompt ver (git context ile)
[ ] 5. Kodu yaz/test et
[ ] 6. Atomic commit'ler at (conventional commits)
[ ] 7. GitHub'a push et
[ ] 8. Pull Request aç (develop ← feature)
[ ] 9. Review yap / test et
[ ] 10. Merge et
[ ] 11. Local feature branch'i sil
[ ] 12. Remote feature branch'i sil
[ ] 13. develop branch'i güncelle (git pull)
[ ] 14. Issue'yu kapat
```

---

**Hazırlayan**: Claude  
**Versiyon**: 1.0.0  
**Güncelleme**: 2024  

**Not**: Bu workflow, tek kişilik projeler için optimize edilmiştir. Takım çalışması için ek branch protection rules ve code review süreçleri eklemelisin.
