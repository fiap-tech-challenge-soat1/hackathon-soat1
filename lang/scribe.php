<?php

return [
    'labels' => [
        'search' => 'Buscar',
        'base_url' => 'URL Base',
    ],

    'auth' => [
        'none' => 'Essa API não é requer authenticação.',
        'instruction' => [
            'query' => <<<'TEXT'
                Para autenticar as requisições, incluir a query string **`:parameterName`** na requisição.
                TEXT,
            'body' => <<<'TEXT'
                Para autenticar as requisições, incluir o parâmetro **`:parameterName`** no corpo (body) da requisição.
                TEXT,
            'query_or_body' => <<<'TEXT'
                To authenticate requests, include a parameter **`:parameterName`** either in the query string or in the request body.
                TEXT,
            'bearer' => <<<'TEXT'
                Para autenticar as requisições, inclua o cabeçalho (header) **`Authorization`** com o valor **`"Bearer :placeholder"`**.
                TEXT,
            'basic' => <<<'TEXT'
                To authenticate requests, include an **`Authorization`** header in the form **`"Basic {credentials}"`**.
                The value of `{credentials}` should be your username/id and your password, joined with a colon (:),
                and then base64-encoded.
                TEXT,
            'header' => <<<'TEXT'
                To authenticate requests, include a **`:parameterName`** header with the value **`":placeholder"`**.
                TEXT,
        ],
        'details' => <<<'TEXT'
            Todas os endpoints que requerem autenticação estão devidamente marcados com `requer autenticação` na documentação abaixo.
            TEXT,
    ],

    'headings' => [
        'introduction' => 'Introdução',
        'auth' => 'Autenticando requisições',
    ],

    'endpoint' => [
        'request' => 'Requisição',
        'headers' => 'Cabeçalhos (headers)',
        'url_parameters' => 'Parâmetros de URL',
        'body_parameters' => 'Parâmetros de corpo (body)',
        'query_parameters' => 'Parâmetros de query',
        'response' => 'Resposta',
        'response_fields' => 'Campos da resposta',
        'example_request' => 'Exemplo de requisição',
        'example_response' => 'Exemplo de resposta',
        'responses' => [
            'binary' => 'Binário',
            'empty' => 'Resposta vazia',
        ],
    ],

    'try_it_out' => [
        'open' => 'Teste ⚡',
        'cancel' => 'Cancelar 🛑',
        'send' => 'Enviar Requisição 💥',
        'loading' => '⏱ Enviando...',
        'received_response' => 'Resposta recebida',
        'request_failed' => 'Requisição falhou com erros',
        'error_help' => <<<'TEXT'
            Dica: Verifique se está devidamente conectado.
            Se você mantém essa API, verifique que a sua API está rodando (up) e você abilitour o CORS.
            Você pode olhar o console de Dev Tools para depurar as informações.
            TEXT,
    ],

    'links' => [
        'postman' => 'Ver coleção do Postman',
        'openapi' => 'Ver especificação do OpenAPI',
    ],
];
