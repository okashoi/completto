FROM php:8.1.9-cli-bullseye

RUN apt-get update && \
    apt-get install -y zip
