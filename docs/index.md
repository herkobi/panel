---
layout: home

hero:
  name: Herkobi® Panel
  text: Temeli hazır, sen ürününe odaklan.
  tagline: Laravel · Inertia · React üzerine kurulu, yönetim paneli ve üye uygulamasını ortak bir altyapıda birleştiren başlangıç kiti. Kimlik doğrulama, yetkilendirme, ayarlar, medya ve modül sistemi hazır gelir.
  image:
    src: /images/hero-panel-dashboard.png
    alt: Herkobi® Panel yönetim ekranı
  actions:
    - theme: brand
      text: Başlarken
      link: /baslarken
    - theme: alt
      text: Mimari
      link: /genel/mimari
    - theme: alt
      text: GitHub
      link: https://github.com/herkobi/panel

features:
  - icon: 🧭
    title: Çift alan, tek sözleşme
    details: Yönetim için /panel, üyeler için /app. Tek auth sözleşmesi auth.type ile ayrışır; kod Panel/* ve App/* olarak aynalanır.
    link: /genel/mimari
    linkText: Mimariyi incele
  - icon: 🔐
    title: Konvansiyonla yetkilendirme
    details: Panel rota adı = yetki adı. Yeni rotalar otomatik korunur; yetkiler "Rotalardan Keşfet" ile arayüzden yönetilir.
    link: /sistemler/yetkilendirme
    linkText: Yetkilendirme
  - icon: 🧩
    title: Modül sistemi
    details: Composer paketleri çekirdeği düzenlemeden panele/app'e menü, rota, yetki, ekran ve mail ekler. Hook + Registry mekanizması.
    link: /sistemler/moduller
    linkText: Modülleri keşfet
  - icon: 👥
    title: Hesap kapsamı
    details: Üye verisi account_id üzerinden izole edilir; bind_account middleware'i otomatik kapsamlar. account_id asla istekten alınmaz.
    link: /genel/mimari
    linkText: Detaylar
  - icon: 🎨
    title: Markalama
    details: Uygulama adı, logo ve favicon ayarlardan gelir; varsayılanlar hazırdır. Açık/koyu tema desteklenir.
    link: /sistemler/markalama
    linkText: Markalama
  - icon: ⚡
    title: Tipli ve hızlı
    details: Wayfinder ile tipli rotalar, @/types ile merkezi TS tipleri, Pest ile testler, Vite + Tailwind v4 + shadcn/ui.
    link: /genel/kod-yapisi
    linkText: Kod yapısı
---
