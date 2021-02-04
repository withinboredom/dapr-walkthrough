# Using Dapr and the PHP SDK

A walkthrough on how to use Dapr and the PHP SDK.

// todo: add youtube embed

# Development

1. Install PHP 8.0+
3. Install composer

Run: `composer start`

# Deploy to Kubernetes

1. Have a Kubernetes cluster
2. Have `kubectl` configured and installed
3. Have `helm` configured and installed

## Add the redis chart

Run `helm repo add bitnami https://charts.bitnami.com/bitnami`

## Install redis to the cluster

Run `helm install redis bitnami/redis`

## Install dapr to the cluster

Run `dapr init -k --runtime-version 1.0.0-rc.3`

Check deployment status with `dapr status -k`

## Install components

Run `kubectl apply -f components/pubsub.yaml && kubectl apply -f components/redis.yaml`

## Build containers

1. Update `composer.json` and replace `withinboredom` with your docker hub username under the `build` script 
2. Run `composer build` to build and push the containers

## Deploy the service

1. Update `deployment.yaml` and replace `withinboredom` with your docker hub username
2. Run `kubectl apply -f deployment.yaml`
3. Run `kubectl get pods` to check the status of the deployment

## Profit

1. Wait for at least one pod to start running
2. Run `kubectl port-forward deployment/picker 3000:80`
3. `curl -X POST localhost:3000/receive/receiver_id/bin_id/upc` and get a new inventory id!
