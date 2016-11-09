# network-graphic

## CRON

A CRON deve ser:

```
* * * * * /usr/bin/php  [path-to-project]/cron-networksave.php > /dev/null 2>&1
```

## Permissões

A pasta `networksaved` precisa permissão de escrita