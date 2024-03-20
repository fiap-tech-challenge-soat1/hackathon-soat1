# Hackathon Timer App

App para competição do Hackathon.

### Subir Aplicação

```bash
docker compose up -d
```

### Gerar Documentação

Para gerar a documentação, primeiro precisa subir a aplicação (o Scribe vai fazer uns requests). Depois, é só rodar:

```bash
docker compose exec app php artisan scribe:generate
```

A documentação vai estar disponível em [localhost/docs](http://localhost/docs).
