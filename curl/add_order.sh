#!/bin/bash

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/order \
  -d "payment_method=1&shipping=1"
