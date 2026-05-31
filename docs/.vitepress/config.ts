import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  lang: 'tr-TR',
  title: 'Herkobi® Panel',
  description:
    'Laravel + Inertia + React üzerine kurulu, panel (yönetim) ve app (üye) alanlarını tek kod tabanında birleştiren başlangıç altyapısı.',

  // GitHub Pages proje sayfası: https://herkobi.github.io/panel/
  base: '/panel/',

  cleanUrls: true,
  lastUpdated: true,

  // public/ altındaki dosyalar statik varlıktır; oradaki .md'leri (ör. görsel
  // listesi README) sayfa olarak tarama — yoksa render aşamasında hash
  // uyuşmazlığı build'i kırıyor.
  srcExclude: ['public/**'],

  // Türkçe başlık slug'ları (ş, ı, ğ) ile sayfa-içi çapa linkleri ASCII'ye
  // katlandığında build'i kırmasın diye sayfa-içi (#...) ölü link denetimi gevşetilir.
  ignoreDeadLinks: true,

  head: [['link', { rel: 'icon', href: '/panel/images/favicon.png' }]],

  themeConfig: {
    logo: {
      light: '/images/herkobi.png',
      dark: '/images/herkobi-white.png',
      alt: 'Herkobi® Panel',
    },
    siteTitle: false, // logo yanındaki "Herkobi" metnini gizle

    nav: [
      { text: 'Giriş', link: '/' },
      { text: 'Başlarken', link: '/baslarken' },
      {
        text: 'Rehber',
        items: [
          { text: 'Mimari', link: '/genel/mimari' },
          { text: 'Kod Yapısı', link: '/genel/kod-yapisi' },
          { text: 'Panel (Yönetim)', link: '/panel/dashboard' },
          { text: 'App (Üye)', link: '/app/' },
        ],
      },
      {
        text: 'Sistemler',
        items: [
          { text: 'Yetkilendirme', link: '/sistemler/yetkilendirme' },
          { text: 'Modül Sistemi', link: '/sistemler/moduller' },
          { text: 'Örnek: Todo Modülü', link: '/sistemler/ornek-todo-modulu' },
          { text: 'Markalama', link: '/sistemler/markalama' },
          { text: 'Kimlik Doğrulama', link: '/sistemler/kimlik-dogrulama' },
        ],
      },
      { text: 'GitHub', link: 'https://github.com/herkobi/panel' },
    ],

    sidebar: [
      {
        text: 'Başlangıç',
        items: [
          { text: 'Giriş', link: '/' },
          { text: 'Başlarken', link: '/baslarken' },
        ],
      },
      {
        text: 'Genel Bakış',
        items: [
          { text: 'Mimari', link: '/genel/mimari' },
          { text: 'Kod Yapısı', link: '/genel/kod-yapisi' },
        ],
      },
      {
        text: 'Panel (Yönetim)',
        collapsed: false,
        items: [
          { text: 'Başlangıç Ekranı', link: '/panel/dashboard' },
          { text: 'Üyeler', link: '/panel/uyeler' },
          { text: 'Araçlar', link: '/panel/araclar' },
          { text: 'Ayarlar', link: '/panel/ayarlar' },
          { text: 'Profil & Güvenlik', link: '/panel/profil' },
        ],
      },
      {
        text: 'App (Üye)',
        items: [{ text: 'Üye Alanı', link: '/app/' }],
      },
      {
        text: 'Sistemler',
        collapsed: false,
        items: [
          { text: 'Yetkilendirme', link: '/sistemler/yetkilendirme' },
          { text: 'Modül Sistemi', link: '/sistemler/moduller' },
          { text: 'Örnek: Todo Modülü', link: '/sistemler/ornek-todo-modulu' },
          { text: 'Markalama', link: '/sistemler/markalama' },
          { text: 'Kimlik Doğrulama', link: '/sistemler/kimlik-dogrulama' },
          { text: 'Medya', link: '/sistemler/medya' },
          { text: 'Bildirimler & E-posta', link: '/sistemler/bildirimler' },
        ],
      },
    ],

    search: {
      provider: 'local',
      options: {
        translations: {
          button: { buttonText: 'Ara', buttonAriaLabel: 'Ara' },
          modal: {
            noResultsText: 'Sonuç bulunamadı',
            resetButtonTitle: 'Aramayı temizle',
            footer: {
              selectText: 'seç',
              navigateText: 'gezin',
              closeText: 'kapat',
            },
          },
        },
      },
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/herkobi/panel' },
    ],

    docFooter: { prev: 'Önceki', next: 'Sonraki' },
    outline: { label: 'Bu sayfada' },
    lastUpdatedText: 'Son güncelleme',
    darkModeSwitchLabel: 'Görünüm',
    sidebarMenuLabel: 'Menü',
    returnToTopLabel: 'Başa dön',

    footer: {
      message: 'MIT lisansı ile yayınlanmıştır.',
      copyright: '© 2026 Herkobi® Dijital Çözümler A.Ş.',
    },
  },
})
