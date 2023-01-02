cd ~/
git clone https://github.com/kunkanon/pdo_ibm-patched
cd pdo_ibm-patched
phpize
./configure --with-pdo-ibm=/opt/ibm/dsdriver/lib
sudo make install
cd ..