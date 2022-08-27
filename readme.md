# IMSExport
app for export IMS standart, Cartridge, QTI, Discussions

#### How can use

1. clone the repository
2. Go to docker folder
   `cd docker`
3. Build container
   `docker-compose build`
4. Up container
   `docker-compose up -d`
5. Connect with bash terminal into image
   `docker exec -it IMSExport bash`
6. Install depdendencies
   `php composer.phar install`
7. go to http://localhost/IMSExport/xml
if download ejemplo.xml, then it's work