FROM kibatic/symfony:7.1

RUN apt-get -qqq update && DEBIAN_FRONTEND=noninteractive apt-get install -qqq -y \
        make \
        wget \
        curl \
        gdebi \
        php7.1-curl \
        php7.1-mysql \
        php7.1-apcu \
        default-jre \
        && \
    wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.2.1/wkhtmltox-0.12.2.1_linux-jessie-amd64.deb && \
    gdebi --n wkhtmltox-0.12.2.1_linux-jessie-amd64.deb && \
    rm wkhtmltox-0.12.2.1_linux-jessie-amd64.deb && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
