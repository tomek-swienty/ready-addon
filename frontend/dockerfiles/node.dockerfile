FROM node:22-alpine

RUN mkdir -p /var/www/html

COPY app/package.json /var/www/html

WORKDIR /var/www/html

RUN npm install --verbose

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]