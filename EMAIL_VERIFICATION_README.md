# E-posta Doğrulama Sistemi Kurulumu

Bu belge, EduCoach uygulamasına eklenen e-posta doğrulama özelliği için kurulum ve yapılandırma adımlarını içerir.

## .env Dosya Ayarları

E-posta doğrulama sisteminin çalışması için `.env` dosyanızda aşağıdaki ayarların bulunduğundan emin olun:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=c627b6a1698ecc
MAIL_PASSWORD=şifrenizi_buraya_yazın
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@educoach.com"
MAIL_FROM_NAME="EduCoach"
```

Gerçek e-posta göndermek için bir SMTP sunucusuna ihtiyacınız olacaktır. Geliştirme aşamasında [Mailtrap](https://mailtrap.io/) kullanabilirsiniz.

## E-posta Doğrulama Nasıl Çalışır?

1. Kullanıcı siteye kayıt olduğunda, sistemde bir hesap oluşturulur ancak `email_verified_at` alanı boş kalır.
2. Kullanıcıya otomatik olarak bir doğrulama e-postası gönderilir.
3. Kullanıcı e-postasındaki doğrulama bağlantısına tıkladığında, hesabı doğrulanır ve `email_verified_at` alanı güncellenir.
4. Doğrulanmamış hesaplar sisteme giriş yapamaz ve korumalı sayfalara erişemez.

## Önemli Notlar

- `VerifyEmail` ve `MustVerifyEmail` arayüzleri kullanılarak Laravel'in yerleşik e-posta doğrulama sistemi uygulanmıştır.
- `auth` ve `verified` middleware'leri kullanarak, doğrulanmamış kullanıcılar korumalı sayfalara erişemez.
- Eğer bir kullanıcı doğrulama e-postasını almadıysa veya bağlantı süresi dolmuşsa, giriş sayfasında yeni bir doğrulama bağlantısı isteyebilir.

## Test Etme

1. Uygulamanızı çalıştırın ve yeni bir hesap oluşturun.
2. Mailtrap (veya kullandığınız e-posta hizmeti) üzerinden gönderilen doğrulama e-postasını kontrol edin.
3. E-postadaki doğrulama bağlantısına tıklayın.
4. Doğrulama yapıldığında, başarıyla giriş yapabilmeniz gerekir.

## Sorun Giderme

- E-posta gönderme sorunları için `storage/logs/laravel.log` dosyasını kontrol edin.
- Eğer doğrulama e-postaları gelmiyorsa, `.env` dosyasındaki e-posta ayarlarını kontrol edin.
- Doğrulama bağlantıları geçersizse, uygulama URL'sinin `.env` dosyasında doğru şekilde ayarlandığından emin olun. 