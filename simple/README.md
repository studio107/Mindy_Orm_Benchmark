`time php run.php typical_page`:

```
->all() as objects: 2.27 MB
->asArray()->all() as array: 2.27 MB
php run.php typical_page  1.98s user 0.02s system 99% cpu 2.005 total
```

`time php run.php 1000`:

```
Total models: 1000
6.86 MB
php run.php 1000  1.98s user 0.02s system 99% cpu 2.001 total
```
