FROM node:22-alpine as build-stage

WORKDIR /var/www/html

COPY package*.json ./

RUN npm install
RUN npm run build

#COPY --from=build-stage /app/dist /app

CMD ["npm", "run", "dev"]