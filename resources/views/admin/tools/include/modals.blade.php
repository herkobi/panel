<div class="modal modal-blur fade" id="cacheModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.tools.cache.clear') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Dikkat!</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-secondary mb-3">Uygulama önbelleğini temizlemek üzeresiniz.</div>
                    <p>Uygulama önbelleği, veritabanı sorguları, nesne örnekleri ve diğer veriler gibi uygulama
                        tarafından önceden hesaplanmış verileri depolar.</p>
                    <p>Bu komutu, veritabanınızda değişiklik yaptıktan veya uygulamanızın performansında bir düşüş
                        fark ettikten sonra kullanabilirsiniz.</p>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn border-0 bg-white text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                            Devam Et ve Temizle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="optimizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.tools.optimize.clear') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Dikkat!</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-secondary mb-3">Önbelleğe alınmış tüm verileri temizlemek üzeresiniz.</div>
                    <p>Görüntüleme önbelleği, rota önbelleği, yapılandırma önbelleği ve uygulama önbelleği gibi.</p>
                    <p>Bu komutu, uygulamanızda büyük değişiklikler yaptıktan sonra veya önbelleğin hatalı olduğunu
                        düşündüğünüz durumlarda kullanabilirsiniz.</p>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn border-0 bg-white text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                            Devam Et ve Temizle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.tools.view.clear') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Dikkat!</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-secondary mb-3">Derlenmiş görüntüleme önbelleğini temizlemek üzeresiniz.</div>
                    <p>Derlenmiş görüntüler, daha hızlı sayfa yükleme süreleri için önceden işlenmiş PHP kodudur.
                    </p>
                    <p>Bu komutu, yeni bir şablon oluşturduktan veya mevcut bir şablonda değişiklik yaptıktan sonra
                        kullanabilirsiniz.</p>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn border-0 bg-white text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                            Devam Et ve Temizle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="routeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.tools.route.clear') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Dikkat!</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-secondary mb-3">Rota önbelleğini temizlemek üzeresiniz.</div>
                    <p>Rota önbelleği, URL'lerin belirli rotalara nasıl eşleştiğini depolar.</p>
                    <p>Bu komutu, yeni bir rota ekledikten veya mevcut bir rotanın yolunu değiştirdikten sonra
                        kullanabilirsiniz.</p>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn border-0 bg-white text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                            Devam Et ve Temizle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="configModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.tools.config.clear') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Dikkat!</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-secondary mb-3">Yapılandırma önbelleğini temizlemek üzeresiniz.</div>
                    <p>Yapılandırma önbelleği, uygulama ayarlarını depolar.</p>
                    <p>Bu komutu, bir yapılandırma ayarını değiştirdikten sonra kullanabilirsiniz.</p>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn border-0 bg-white text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                            Devam Et ve Temizle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.tools.event.clear') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Dikkat!</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-secondary mb-3">Etkinlik önbelleğini temizlemek üzeresiniz.</div>
                    <p>Etkinlik önbelleği, uygulama ayarlarını depolar.</p>
                    <p>Bu komutu yeni olay dinleyicileri eklediğinizde, güncellediğinizde veya sildiğinizde
                        değişikliklerin devreye girmesi için kullanabilirsiniz.</p>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn border-0 bg-white text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                            Devam Et ve Temizle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
