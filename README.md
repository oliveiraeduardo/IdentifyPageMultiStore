# Magento Custom Module
========

# IdentifyPageMultiStore

O módulo Evino `IdentifyPageMultiStore` responsável por adicionar uma meta tag no header das páginas para identificar quais estão sendo utilizadas em mais de uma store/website.

## Instalation

```console
~$ bin/magento module:enable CustomMagentoModule_IdentifyPageMultiStore
```

## How It Works

No header de cada página, é incluso uma meta tag no formato:
```
  <link rel="alternate" hreflang="idioma-web-site" href="url-pagina">
```

Essa tag não está visível. Por isso, para localizar essa informação deve inspecionar o header da página (click com botão direito do mouse ==> Inspecionar).
Irá abrir o console do navegador demonstrando o HTML da página. Para ser ainda mais fácil localizar, execute o comando Ctrl + F (irá apresentar o campo de busca no console) e digite hreflang. Ao clicar em buscar, irá posicionar exatamente onde está localizada a meta tag

## Block

- `\CustomMagentoModule\IdentifyPageMultiStore\Block\MetaTag`:\
  Block responsável por métodos para identificação de página e qual store/website está utilizando ela.
