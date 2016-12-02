# iprange2cidr
Convert IP range to multi cidr

# Example
```
$ php iprange2cidr.php 
array(4) {
  [0]=>
  string(12) "211.1.1.5/32"
  [1]=>
  string(12) "211.1.1.6/31"
  [2]=>
  string(12) "211.1.1.8/29"
  [3]=>
  string(13) "211.1.1.16/29"
}
array(2) {
  [0]=>
  string(12) "211.1.1.5/32"
  [1]=>
  string(12) "211.1.1.6/32"
}
array(9) {
  [0]=>
  string(9) "1.0.0.0/8"
  [1]=>
  string(9) "2.0.0.0/7"
  [2]=>
  string(9) "4.0.0.0/6"
  [3]=>
  string(9) "8.0.0.0/5"
  [4]=>
  string(10) "16.0.0.0/4"
  [5]=>
  string(10) "32.0.0.0/3"
  [6]=>
  string(10) "64.0.0.0/2"
  [7]=>
  string(11) "128.0.0.0/8"
  [8]=>
  string(12) "129.0.0.0/32"
}
```
