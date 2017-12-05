# APNS_Safari_Push

  Send push notification to Safari. You have give the **pem Cert** (`Line 7`), **password of pem cert** (`Line 10`), and **Token** (`Line 13`).

  Add your payload from `Line 62-65`.

  Enjoy !!......

# Where to get the Entrust Root CA PEM file

  1. Launch `Keychain Assistant` 
  2. click on `System Root Certificate` 
  3. Select the `Certificates` on the bottom-left 
  4. Right-click on `Entrust.net Certification Authority (2048)` and export with `Entrust.net Certification Authority (2048).pem` file name and choose as document format `Privacy Enhanced Mail (.pem)`. 
  5. Now you can use this PEM file as Entrust Root Certification Authority in php to verify Apple Peer!
