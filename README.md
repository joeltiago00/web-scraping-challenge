>  This is a challenge by [Coodesh](https://coodesh.com/)

## Backend Challeng API 😎
> API feita para sincronizar produtos do site Open Food Facts.
> 
> >Linguagem de programação: PHP <br> Framework: Laravel <br> Container: Docker <br> Serviços AWS: SES, Lambda

## Criando containers 🐳

> Para construir os containers basta executar:
> >docker-compose up -d --build
> 
> Após construir os container é necessário instalar as dependências do composer, execute:
> > docker-compose exec -T app composer install
>  
> Extra: caso seja necessário entrar no container basta executar:
> > docker-compose exec app bash 

## Rodando script de importação de produtos manualmente ⌨

> Lembre-se: para executar o script manualmente é necessário estar dentro do container.
> 
> Execute: 
> > php artisan sync:products-open-food-facts

## Rotas 🛬
> Teste API
> > /api/test 
> > 
> Listagem de produtos
> > /api/products?pp=10&pg=1
> > 
> > > OBS: No máximo 15 produtos por página! 
> 
> Exibir produto
> > /api/products/{code}


