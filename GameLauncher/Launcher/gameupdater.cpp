#include "gameupdater.h"

GameUpdater::GameUpdater(QObject *parent) : QObject(parent)
{
    settings    = new Settings();
networkclient   = new QNetworkAccessManager();

QString urlstring = QString("ftp://");
urlstring.append(settings->host.append("/patchinfo.dat"));

target = new QUrl(urlstring);

    target->setPassword("12345");
    target->setUserName("user");

const QNetworkRequest request = new QNetworkRequest();
request.setUrl(target);

reply   = networkclient->get(request);



connect(networkclient, SIGNAL(ready), this, SLOT(DownloadComplete()));
//connect(networkclient, SIGNAL(error(QNetworkReply::NetworkError)), SLOT(requestError(reply));


}

GameUpdater::~GameUpdater()
{

}

void GameUpdater::DownloadPatchInfo()
{

    // Connect to FTP
    networkclient->connectToHost(settings->host,21);
}

void GameUpdater::CheckForUpdate()
{

}

void GameUpdater::DownloadComplete()
{

}
