FROM nginx
ADD nginx/default.conf /etc/nginx/conf.d/
RUN mkdir -p /var/www/html