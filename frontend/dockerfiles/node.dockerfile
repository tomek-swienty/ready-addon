FROM node:22-alpine

RUN mkdir -p /var/www/html

COPY app/package.json /var/www/html

WORKDIR /var/www/html

RUN npm run build

EXPOSE 3021

CMD ["npm", "run", "dev"]