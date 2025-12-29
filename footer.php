<?php
// Ortak footer parçası — modern ve proje uyumlu görünüm
?>
<style>
    .cep-footer { background: linear-gradient(180deg,#071026 0%, #050816 100%); color:#d1e8ff; padding:36px 20px; border-top:1px solid rgba(255,255,255,0.04); }
    .cep-footer .inner{max-width:1100px;margin:0 auto;display:flex;gap:20px;align-items:center;justify-content:space-between;flex-wrap:wrap}
    .cep-footer .left{display:flex;gap:14px;align-items:center;min-width:280px}
    .cep-footer svg{width:44px;height:44px}
    .cep-footer .brand-title{font-weight:800;color:#fff;font-size:1.05rem}
    .cep-footer .desc{opacity:0.9;line-height:1.5;color:#cfe7ff}
    .cep-footer .right{text-align:right;min-width:220px}
    .cep-footer a{color:#93c5fd;text-decoration:none}
    .cep-footer .meta{margin-top:8px;font-size:0.92rem;opacity:0.95}
    @media(max-width:700px){ .cep-footer .right{width:100%;text-align:left} .cep-footer .inner{flex-direction:column;align-items:flex-start} }
</style>

<footer class="cep-footer" role="contentinfo">
    <div class="inner">
        <div class="left">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                <defs>
                    <linearGradient id="f1" x1="0" x2="1">
                        <stop offset="0" stop-color="#6EE7B7"/>
                        <stop offset="1" stop-color="#60A5FA"/>
                    </linearGradient>
                </defs>
                <rect width="64" height="64" rx="12" fill="#071026" />
                <path d="M16 40 L28 20 L36 34 L48 16" stroke="url(#f1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <div>
                <div class="brand-title">CepKampüs</div>
                <div class="desc">Bu proje üniversite ve kulüp bilgilerinin görsel olarak sunulması amacıyla geliştirilmiştir. Daha fazla bilgi için <a href="about.php">Hakkında</a> sayfasını ziyaret edebilirsiniz.</div>
            </div>
        </div>

        <div class="right">
            <div>İletişim: <a href="mailto:emre@example.com">emre@example.com</a></div>
            <div class="meta">© <?php echo date('Y'); ?> CepKampüs — <a href="report.php">Proje Raporu</a></div>
        </div>
    </div>
</footer>
