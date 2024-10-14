FROM node:22-alpine as build-stage

WORKDIR /app

COPY package*.json ./

RUN npm install
RUN npm run build

FROM nginx as production-stage

EXPOSE 3000

RUN mkdir /app

COPY nginx/default.conf /etc/nginx/conf.d/default.conf

#COPY --from=build-stage /app/dist /app

CMD ["npm", "run", "dev"]