FROM node:22-alpine

RUN mkdir -p /var/www/html

COPY app/package.json /var/www/html

WORKDIR /var/www/html

RUN npm install

#RUN npm run build

EXPOSE 3077

CMD ["npm", "run", "serve"]