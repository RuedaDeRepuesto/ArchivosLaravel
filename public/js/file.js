class File {
    

    constructor(data) {
        Object.assign(this, data);
    }

    toDiv()
    {
        var ext="";
        if(this.icon =="icons/file.png")
        {
            ext=`<i class="ext">${this.extension}</i>`;
        }
        const div= `
            <div class="file" onclick="selectFile(this);" draggable="true" ondblclick="openFile(${this.id})" id="${this.id}" data-file-mime="${this.mime}" data-file-url="${api_url}/files/${this.id}/file" data-file-id="${this.id}">
                <img draggable="false" src="${this.icon}" class="icon">
                ${ext}
                <p onclick="editName(this);">${this.name}</p>
            </div>
        `;

        
        
        this.getPreview();

        return div;
    }

    async getPreview()
    {
        if(this.mime.search("image") != -1)
        {
            axios.get(api_url+"/files/"+this.id+"/preview",{ responseType: 'arraybuffer' }).then(resp => {
                debug("get image data");
                
                this.icon=convertToImage(resp.data);
                debug("convertida")
                
                $('.file[data-file-id="'+this.id+'"] > img ').attr("src",this.icon).addClass("preview");
                return true;
            });
        }
        return 0;
    }
}


function convertToImage(data) {
    const base64 = btoa(
        new Uint8Array(data).reduce(
            (data, byte) => data + String.fromCharCode(byte),
            '',
        ),
        );
        img="data:;base64," + base64;
    return img;
}