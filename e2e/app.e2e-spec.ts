import { SongdomPage } from './app.po';

describe('songdom App', function() {
  let page: SongdomPage;

  beforeEach(() => {
    page = new SongdomPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
