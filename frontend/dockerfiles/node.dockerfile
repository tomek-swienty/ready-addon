FROM node:22-alpine

WORKDIR /var/www/html

RUN npm install

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]