# Öğrenci Koçluk Sistemi

Bu proje, öğrenciler ve koçlar arasındaki iletişimi ve koçluk sürecini yönetmek için geliştirilmiş bir web uygulamasıdır.

## Özellikler

- Öğrenci ve koç kayıt sistemi
- Oturum yönetimi ve güvenli kimlik doğrulama
- E-posta doğrulama sistemi
- Koçluk seansları planlama ve takibi
- İlerleme raporları ve değerlendirmeler
- Mesajlaşma sistemi

## Gereksinimler

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite
- Web sunucusu (Apache/Nginx)

## Kurulum

1. Projeyi klonlayın:
```bash
git clone https://github.com/kullaniciadi/ogrenci_kocluk.git
cd ogrenci_kocluk
```

2. Composer bağımlılıklarını yükleyin:
```bash
composer install
```

3. Ortam değişkenlerini ayarlayın:
```bash
cp .env.example .env
php artisan key:generate
```

4. `.env` dosyasında veritabanı ayarlarını yapılandırın:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ogrenci_kocluk
DB_USERNAME=root
DB_PASSWORD=
```

5. Veritabanı migration'larını çalıştırın:
```bash
php artisan migrate
```

6. Frontend bağımlılıklarını yükleyin:
```bash
npm install
npm run dev
```

7. Uygulamayı başlatın:
```bash
php artisan serve
```

Uygulama http://localhost:8000 adresinde çalışmaya başlayacaktır.

## Geliştirme

- `php artisan serve` komutu ile geliştirme sunucusunu başlatın
- `npm run dev` komutu ile Vite geliştirme sunucusunu başlatın

## Katkıda Bulunma

1. Bu depoyu fork edin
2. Yeni bir branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some amazing feature'`)
4. Branch'inizi push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Daha fazla bilgi için `LICENSE` dosyasına bakın.

## İletişim

Proje Sahibi - [@github_username](https://github.com/github_username)

Proje Linki: [https://github.com/github_username/ogrenci_kocluk](https://github.com/github_username/ogrenci_kocluk)
