FROM nginx
ADD ./routing/default.conf /etc/nginx/conf.d/
RUN mkdir -p /var/www/html