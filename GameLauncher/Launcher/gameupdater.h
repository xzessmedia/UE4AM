#ifndef GAMEUPDATER_H
#define GAMEUPDATER_H

#include <QObject>
#include <QUrl>
#include <QNetworkRequest>
#include <QNetworkReply>
#include <QNetworkAccessManager>
#include "settings.h"

class GameUpdater : public QObject
{
    Q_OBJECT
public:
    explicit GameUpdater(QObject *parent = 0);
    ~GameUpdater();

    QNetworkAccessManager *networkclient;
    QNetworkReply         *reply;
    QUrl                  *target;
    Settings              *settings;

    void DownloadPatchInfo();
    void CheckForUpdate();
signals:

public slots:
    void DownloadComplete();
    void requestError(QNetworkReply NetworkError);
};

#endif // GAMEUPDATER_H
