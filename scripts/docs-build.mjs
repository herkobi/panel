// VitePress üretim derlemesi — temiz başlangıç + retry.
//
// VitePress 1.6.x'te bilinen, aralıklı (flaky) bir render hatası var:
// "Cannot read properties of undefined (reading 'imports')" (resolvePageImports,
// pMap.concurrency). İçerik hatası değil, paralel render yarışı; aynı girdiyle
// bir denemede patlayıp sonrakinde geçebiliyor. Bu sarmalayıcı, her denemeden
// önce cache/dist'i temizler ve başarısız olursa birkaç kez yeniden dener.

import { rmSync } from 'node:fs'
import { execSync } from 'node:child_process'

const BASE = 'docs/.vitepress'
const MAX_ATTEMPTS = 3

function clean() {
  for (const dir of ['cache', 'dist']) {
    rmSync(`${BASE}/${dir}`, { recursive: true, force: true })
  }
}

for (let attempt = 1; attempt <= MAX_ATTEMPTS; attempt++) {
  clean()
  try {
    execSync('npx --no-install vitepress build docs', { stdio: 'inherit' })
    process.exit(0)
  } catch {
    console.error(`\n[docs-build] deneme ${attempt}/${MAX_ATTEMPTS} başarısız.`)
    if (attempt === MAX_ATTEMPTS) {
      console.error('[docs-build] tüm denemeler başarısız oldu.')
      process.exit(1)
    }
    console.error('[docs-build] yeniden deneniyor...\n')
  }
}
