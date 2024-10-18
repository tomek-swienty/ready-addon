FROM nginx:stable-alpine

COPY dockerfiles/nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html

ENTRYPOINT ["nginx", "-g", "daemon off;"]

EXPOSE 8080