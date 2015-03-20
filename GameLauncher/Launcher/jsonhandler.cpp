#include "jsonhandler.h"

JsonHandler::JsonHandler()
{

}


JsonHandler::~JsonHandler()
{

}

void JsonHandler::PostJsonData()
{
    QUrl url(SYNC_URL);
    QNetworkRequest request(url);

    request.setHeader(QNetworkRequest::ContentTypeHeader, "application/json");

    QNetworkAccessManager *manager = new QNetworkAccessManager(this);

    connect(manager, SIGNAL(finished(QNetworkReply*)),
            this, SLOT(syncRequestFinished(QNetworkReply*)));

    QByteArray data = QtJson::Json::

    // FIXME for debug
    qDebug() << "Sync" << QString::fromUtf8(data.data(), data.size());

    manager->post(request, data);
}

