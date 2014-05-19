Тест основан на https://github.com/lox/php-orm-benchmark.

Результаты:

```
Class                         INSERT         PK_SEARCH      ENUMERATE      SEARCH         N+1
Amiss_3_0_3                   0.61ms         0.23ms         0.4363ms       5.6003ms       1.0601ms
Mindy                         4.95ms         3.13ms         19.7279ms      21.0019ms      32.5439ms
Mysqli_Prepared               0.59ms         0.22ms         0.2527ms       5.0494ms       0.3058ms
Mysqli                        0.50ms         0.11ms         0.1614ms       5.0269ms       1.2294ms
Pdo_Bound                     0.53ms         0.12ms         0.1777ms       5.0977ms       1.2850ms
Pdo                           0.50ms         0.12ms         0.1526ms       4.8767ms       1.3559ms
Pheasant_1_1_0                1.70ms         0.69ms         1.3117ms       9.2178ms       5.1661ms
```
