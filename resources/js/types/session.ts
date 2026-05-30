export type SessionItem = {
    id: string;
    ip_address: string | null;
    user_agent: string | null;
    device: string;
    browser: string;
    platform: string;
    login_at: string | null;
    last_activity_at: string;
    is_current: boolean;
    session_count: number;
};

/**
 * Üye/kullanıcı detay ekranındaki giriş geçmişi satırı
 * (yadahan/laravel-authentication-log kaydı).
 */
export type UserSessionLog = {
    id: number;
    ip_address: string | null;
    user_agent: string | null;
    device: string;
    browser: string;
    platform: string;
    login_at: string | null;
    logout_at: string | null;
};
